<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\project;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    public function project(){
        $construction_types = DB::table('categories')->orderBy('id')->get();
        $expected_timeline =DB::table('expected_timeline')->orderBy('id')->get();
        $budgets = DB::table('budget_range')->orderBy('id')->get();
        $role_types = DB::table('role')->get();
        return view('web.project',compact('construction_types','role_types','expected_timeline','budgets'));
    }

    public function getSubCategories(Request $request)
    {
        $project_type_id = $request->project_type_id;
        $category_id = $request->construction_type_id;

        $results = DB::table('project_cat_type')
            ->join('construction_sub_categories', 'project_cat_type.const_sub_cat_id', '=', 'construction_sub_categories.id')
            ->where('project_cat_type.project_types_id', $project_type_id)
            ->where('project_cat_type.categories_id', $category_id)
            ->select('construction_sub_categories.id as const_sub_cat_id', 'construction_sub_categories.name as sub_category_name')
            ->get();

        return response()->json($results);
    }

    public function getProjectTypes(Request $request)
    {
        $category_id = $request->construction_type_id;

        $types = DB::table('project_cat_type')
            ->join('project_types', 'project_cat_type.project_types_id', '=', 'project_types.id')
            ->where('project_cat_type.categories_id', $category_id)
            ->select('project_types.id', 'project_types.name')
            ->distinct()
            ->get();

        return response()->json($types);
    }


    public function storeproject(Request $request)
    {
        // Validate form (added rules for arch_drawings + arch_files)
        $validated = $request->validate([
            'full_name'            => 'required|string|max:255',
            'phone_number'         => ['required','string','max:20'],
            'email'                => 'required|email|max:255',
            'password'             => 'required|string|min:6|confirmed', // expects password_confirmation
            'role_id'              => 'required|integer',
            'construction_type_id' => 'required|integer',
            'project_type_id'      => 'required|integer',
            'expected_start'       => 'nullable|date',
            'land_area'            => 'nullable|numeric',

            // NEW: drawings toggle + multi-pdf uploads
            'arch_drawings'        => 'nullable',
            'arch_files'           => 'required_if:arch_drawings,1|array',
            'arch_files.*'         => 'file|mimetypes:application/pdf|max:10240', // 10 MB per file

            'struct_drawings'  => 'nullable',
            'struct_files'     => 'required_if:struct_drawings,1|array',
            'struct_files.*'   => 'file|mimetypes:application/pdf|max:10240', // 10MB per file


            // Optional (if you send as array from UI)
            'sub_categories'       => 'nullable|array',
            'sub_categories.*'     => 'nullable|string'
        ]);

        // Handle optional BOQ upload (existing)
        $boqPath = null;
        if ($request->hasFile('boq_file')) {
            $boqPath = $request->file('boq_file')->store('boq_files', 'public');
        }

        // Handle multiple Architectural Drawing PDFs (NEW)
        $archPaths = [];
        if ($request->boolean('arch_drawings') && $request->hasFile('arch_files')) {
            foreach ($request->file('arch_files') as $file) {
                // stored at storage/app/public/arch_drawings/...
                $archPaths[] = $file->store('arch_drawings', 'public');
            }
        }
        // Handle multiple Structural Drawing PDFs
        $structPaths = [];
        if ($request->boolean('struct_drawings') && $request->hasFile('struct_files')) {
            foreach ($request->file('struct_files') as $file) {
                $structPaths[] = $file->store('struct_drawings', 'public'); // storage/app/public/struct_drawings
            }
        }

        // Sub-categories (array -> CSV if you want to keep old field)
        $subCategoriesCsv = is_array($request->sub_categories)
            ? implode(',', $request->sub_categories)
            : null;

        // Create the project
        $project = Project::create([
            'full_name'            => $request->full_name,
            'phone_number'         => $request->phone_number,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'role_id'              => $request->role_id,
            'construction_type_id' => $request->construction_type_id,
            'project_type_id'      => $request->project_type_id,

            'site_ready'           => $request->has('site_ready'),
            'sub_categories'       => $subCategoriesCsv,      // if your column is a string
            'land_location'        => $request->land_location,
            'survey_number'        => $request->survey_number,
            'land_type'            => $request->land_type,
            'land_area'            => $request->land_area,
            'land_unit'            => $request->land_unit,

            'arch_drawings'        => $request->has('arch_drawings'),
            'struct_drawings'      => $request->has('struct_drawings'),
            'has_boq'              => $request->has('has_boq'),
            'boq_file'             => $boqPath,
            'expected_start'       => $request->expected_start,
            'project_duration'     => $request->project_duration,
            'budget_range'         => $request->budget_range,

            // Save the drawings file paths (JSON recommended)
            'arch_files'           => !empty($archPaths) ? json_encode($archPaths) : null,
        ]);

        session(['current_project_id' => $project->id]);

        return response()->json([
            'success'  => true,
            'redirect' => route('project_details'),
        ]);
    }

    public function project_details(){
        $projectId = session('current_project_id');
        // dd($projectId);
        if (!$projectId) {
            return redirect('/')->with('error', 'No project found in session.');
        }

        $project = Project::findOrFail($projectId);

        return view('web.project_details', compact('project'));
    }

  
    public function project_details_save(Request $request)
    {
        $projectId = session('current_project_id');
        $request->validate([
            'project_name' => 'required|string',
            'project_description' => 'nullable|string',
            'file_path.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $filePaths = [];

        // Handle file upload first
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $file) {
                $path = $file->store('file_path', 'public'); // store in storage/app/public/project_files
                $filePaths[] = $path;
            }
        }

        // $submission_id = 'PI'.'/'.$projectId;
        $submission_id = 'PI/' . date('Y') . '/' . str_pad($projectId, 6, '0', STR_PAD_LEFT);

        // Insert project into DB
        $projectId = DB::table('projects_details')->insertGetId([
            'project_id' => $projectId,
            'submission_id' =>$submission_id ,
            'project_name' => $request->project_name,
           
            'project_description' => $request->project_description,
            'file_path' => !empty($filePaths) ? json_encode($filePaths) : null, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'project_id' => $projectId]);
    }

    // public function customer_dashboard(){
    //     $session = session('current_project_id');
    //     $projects  = DB::table('projects')
    //                         ->where('id',$session)
    //                         ->get();

                            
    //     dd($projects);
    //     return view('web.customer_dashboard',compact('session','projects'));
    // }
    // public function customer_dashboard()
    // {
    //     $session = session('current_project_id');
        
    //     $cust_details= DB::table('projects')
    //                     ->where('id', $session)
    //                     ->first();
    //     $projects = DB::table('projects_details')
    //                     ->where('project_id', $session)
    //                     ->get();                

    //     return view('web.customer_dashboard', compact('projects','cust_details'));
    // }
public function customer_dashboard()
{
    $user = session('user'); // ✅ use user session directly

    if (!$user) {
        return redirect('/login')->with('error', 'Session expired, please login again.');
    }

    $cust_details = DB::table('projects')
                        ->where('id', $user->id)
                        ->first();

    $projects = DB::table('projects_details')
                        ->where('project_id', $user->id)
                        ->get();

    return view('web.customer_dashboard', compact('projects', 'cust_details'));
}

    // public function Partner_Bids(){
    //      $projectId = session('current_project_id');
    //      $like_project_list_vendor = DB::table('projects')
    //                                 ->where('id', $projectId)
    //                                 ->get();

    //      $vendor_details = DB::table('project_likes')
    //                                 ->where('vendor_id', $like_project_list_vendor->id)
    //                                 ->get();                      
    //      dd($like_project_list_vendor);
    //     return view('web.Partner_Bids',compact('like_project_list_vendor'));
    // }
//     public function Partner_Bids() {
//     $projectId = session('current_project_id');

//     // Get the specific project (not as a collection)
//     $like_project_list_vendor = DB::table('projects')
//                                   ->where('id', $projectId)
//                                   ->first(); // ✅ important

//     // Now this works since $like_project_list_vendor is an object
//     $vendor_details = DB::table('project_likes')
//                         ->where('vendor_id', $like_project_list_vendor->id)
//                         ->first();
//     $vendor_id = DB::table('service_provider')
//                         ->where('vendor_id', $vendor_details->id)
//                         ->first();
//     // Optional: Debug
//     dd($vendor_id);

//     return view('web.Partner_Bids', compact('like_project_list_vendor', 'vendor_details'));
// }
// public function Partner_Bids() {
//     $projectId = session('current_project_id');
   
//     // $pro_id = DB::table('projects')
//     //                               ->where('id', $projectId)
//     //                               ->first();
//     // Get the specific project
//     $like_project_list_vendor = DB::table('projects')
//                                   ->where('id', $projectId)
//                                   ->first();
//   dd($like_project_list_vendor);
//     if (!$like_project_list_vendor) {
//         return redirect()->back()->with('error', 'Project not found.');
//     }
//     $vender_id = $like_project_list_vendor->id;
 
//     // Get vendor_like entry for this project
//     $vendor_details = DB::table('project_likes')
//                         ->where('vendor_id', $vender_id)  // ✅ Correct field
//                         ->get();
//   dd($vendor_details);
//     if (!$vendor_details) {
//         return redirect()->back()->with('error', 'No vendor liked this project yet.');
//     }
//     $vendorid = $vendor_details->vendor_id;
//     // Get the actual vendor data from service_provider table
//     $vendor = DB::table('service_provider')
//                 ->where('id', $vendorid) // ✅ Correct usage
//                 ->first();
//   // Debug check
   
//     if (!$vendor) {
//         return redirect()->back()->with('error', 'Vendor not found.');
//     }

//     $tender_data = DB::table('tender_documents')
//                 ->where('project_id', $vendor_details->vendor_id) // ✅ Correct usage
//                 ->get();

//     return view('web.Partner_Bids', compact('like_project_list_vendor', 'vendor_details', 'vendor'));
// }
// public function Partner_Bids() {
//     // $projectId =21;
//     $projectId = session('current_project_id');
// //    dd($projectId);
//     $project = DB::table('projects')
//                 ->where('id', $projectId)
//                 ->first();  
//         // dd($project->id);        
//      $projects_details=   DB::table('projects_details')
//                 ->where('project_id', $projectId)
//                 ->first();         
//     //  dd($projects_details); 
//     $projects_details_id = $projects_details->id;
// //  dd($projects_details_id);  
//     $vendor_details = DB::table('project_likes')
//                         ->where('project_id', $projects_details_id) 
//                         ->get();

//     $vendorIds = $vendor_details->pluck('vendor_id')->toArray();
// //  dd($vendorIds);
//     $vendor = DB::table('service_provider')
//                 ->whereIn('id', $vendorIds)
//                 ->get();
//                  dd($vendor);
   
// //   business_registrations
//      return view('web.Partner_Bids',compact('vendor'));
// //   dd($project);
   
// }
public function Partner_Bids()
{
    $projectId = session('current_project_id');

    $project = DB::table('projects')
        ->where('id', $projectId)
        ->first();  

    $projects_details = DB::table('projects_details')
        ->where('project_id', $projectId)
        ->first();         

    $projects_details_id = $projects_details->id;

    $vendor_details = DB::table('project_likes')
        ->where('project_id', $projects_details_id) 
        ->get();

    $vendorIds = $vendor_details->pluck('vendor_id')->toArray();
  
  
    $vendor = DB::table('service_provider')
                ->leftJoin('business_registrations', 'business_registrations.user_id', '=', 'service_provider.id')
                ->leftJoin('tender_documents', function ($join) use ($projects_details_id) {
                    $join->on('tender_documents.vendor_id', '=', 'service_provider.id')
                        ->where('tender_documents.project_id', $projects_details_id);
                })
                ->whereIn('service_provider.id', $vendorIds)
                ->select(
                    'service_provider.id as service_provider_id',
                    'business_registrations.id as business_registration_id',
                    'tender_documents.id as tender_document_id',
                    'service_provider.*',
                    'business_registrations.*',
                    'tender_documents.*'
                )
                ->orderBy('tender_documents.vendor_cost', 'asc')
                ->get();

// dd($vendor);
    return view('web.Partner_Bids', compact('vendor'));
}

// public function proceedVendor(Request $request)
// {
//     $request->validate([
//         'selected_vendor' => 'required',
//     ]);

//     $vendorId = (string) $request->selected_vendor; // cast to string
//     $projectId = (string) session('current_project_id'); // cast to string

//     $projects_details = DB::table('projects_details')
//         ->where('project_id', $projectId)
//         ->first();

//     $projects_details_id = $projects_details->id ?? null;
//     $customerName = auth()->user()->name ?? 'Customer';
//     // Now set only the chosen vendor to 1
//     $updated = DB::table('project_likes')
//         ->where('project_id', $projectId)
//         ->where('vendor_id', $vendorId)
//         ->update([
//             'selected_vendor' => '1',
//             'updated_at' => now(),
//         ]);

//     return response()->json([
//         'status'               => $updated ? 'success' : 'not_updated',
//         'vendor_id'            => $vendorId,
//         'project_id'           => $projectId,
//         'projects_details_id'  => $projects_details_id,
//         'customer_name'        => $customerName,
//     ]);
// }
// public function proceedVendor(Request $request)
// {
   
//     $request->validate([
//         'selected_vendor' => 'required',
//     ]);

//     $vendorId = (string) $request->selected_vendor; 
//     $projectId = (string) session('current_project_id'); 

//     // Get project details
//     $projects_details = DB::table('projects_details')
//         ->where('project_id', $projectId)
//         ->first();

//     $projects_details_id = $projects_details->id;
   
//     $exists = DB::table('project_likes')
//         ->where('project_id', $projects_details_id)
//         ->where('vendor_id', $vendorId)
//         ->where('selected_vendor','1')
//         ->exists();
// // dd( $exists);
//     if ($exists) {
//         // Update selected vendor
//         echo"alredy selected vendor for this project";
//     } else {
        
//         $updated = DB::table('project_likes')
//                     ->where('project_id', $projects_details_id)
//                     ->where('vendor_id', $vendorId)
//                     ->update([
//                         'selected_vendor' => 1,
//                         'updated_at'      => now(),
//                     ]);

//     }

//     return response()->json([
//         'status'              => $updated ? 'success' : 'failed',
//         'vendor_id'           => $vendorId,
//         'project_id'          => $projectId,
//         'projects_details_id' => $projects_details_id,
       
//     ]);
// }

public function proceedVendor(Request $request)
{
    $request->validate([
        'selected_vendor' => 'required',
    ]);

    $vendorId = (string) $request->selected_vendor; 
    $projectId = (string) session('current_project_id'); 

    // Get project details
    $projects_details = DB::table('projects_details')
        ->where('project_id', $projectId)
        ->first();

    $projects_details_id = $projects_details->id;

    // default value
    $updated = 0;

    $exists = DB::table('project_likes')
        ->where('project_id', $projects_details_id)
        ->where('vendor_id', $vendorId)
        ->where('selected_vendor', '1')
        ->exists();

    if ($exists) {
        // Already selected vendor
        return response()->json([
            'status'  => 'exists',
            'message' => 'Vendor already selected for this project',
            'vendor_id' => $vendorId,
            'project_id' => $projectId,
            'projects_details_id' => $projects_details_id,
        ]);
    } else {
        // Update vendor
        $updated = DB::table('project_likes')
            ->where('project_id', $projects_details_id)
            ->where('vendor_id', $vendorId)
            ->update([
                'selected_vendor' => 1,
                'updated_at'      => now(),
            ]);
    }

    return response()->json([
        'status'              => $updated ? 'success' : 'failed',
        'vendor_id'           => $vendorId,
        'project_id'          => $projectId,
        'projects_details_id' => $projects_details_id,
    ]);
}

}