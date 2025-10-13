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
        $workTypes = DB::table('work_types')->get();
        $construction_types = DB::table('categories')->orderBy('id')->get();
        $expected_timeline =DB::table('expected_timeline')->orderBy('id')->get();
        $budgets = DB::table('budget_range')->orderBy('id')->get();
        $role_types = DB::table('role')->get();
        $states = DB::table('states')->where('is_active',1)->get(); 
        return view('web.project',compact('construction_types','states','role_types','expected_timeline','budgets','workTypes'));
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
        // ✅ Validation
        $validated = $request->validate([
            'full_name'        => 'required|string|max:255',
            'phone_number'     => 'required|string|max:20',
            'email'            => 'required|email|max:255',
            'password'         => 'required|string|min:6|confirmed',
            'role_id'          => 'required|integer',
            'expected_start'   => 'nullable|date',
            'land_area'        => 'nullable|numeric',
            'site_status'      => 'nullable',
            'floors'           => 'nullable',
            'water'            => 'nullable',
            'electricity'      => 'nullable',
            'drainage'         => 'nullable',
            'payment_preference'  => 'nullable',
            'quality_preference'  => 'nullable',
            'vendor_preference'   => 'nullable',
            'best_time'           => 'nullable',

            // Drawings + multi-pdf uploads
            'arch_drawings'   => 'nullable',
            'arch_files'      => 'required_if:arch_drawings,1|array',
            'arch_files.*'    => 'file|mimes:pdf,application/pdf|max:10240',

            'struct_drawings' => 'nullable',
            'struct_files'    => 'required_if:struct_drawings,1|array',
            'struct_files.*'  => 'file|mimes:pdf,application/pdf|max:10240',

            // Dropdowns (can be arrays if multi-select)
            'work_subtype'    => 'nullable',
            'work_type'       => 'nullable',
            'vendor_type'     => 'nullable',
            'sub_vendor_types'=> 'nullable',

            'region'        => 'required',
            'city'        => 'required',
            'state'        => 'required'
            
            
            
        ]);

        // ✅ Handle BOQ upload
        $boqPath = null;
        if ($request->hasFile('boq_file')) {
            $boqPath = $request->file('boq_file')->store('boq_files', 'public');
        }

        // ✅ Handle multiple Architectural Drawing PDFs
        $archPaths = [];
        if ($request->boolean('arch_drawings') && $request->hasFile('arch_files')) {
            foreach ($request->file('arch_files') as $file) {
                $archPaths[] = $file->store('arch_drawings', 'public');
            }
        }

        // ✅ Handle multiple Structural Drawing PDFs
        $structPaths = [];
        if ($request->boolean('struct_drawings') && $request->hasFile('struct_files')) {
            foreach ($request->file('struct_files') as $file) {
                $structPaths[] = $file->store('struct_drawings', 'public');
            }
        }

        // ✅ Convert possible arrays into strings/JSON
        $workType        = is_array($request->work_type) ? json_encode($request->work_type) : $request->work_type;
        $workSubtype     = is_array($request->work_subtype) ? json_encode($request->work_subtype) : $request->work_subtype;
        $vendorType      = is_array($request->vendor_type) ? json_encode($request->vendor_type) : $request->vendor_type;
        $subVendorTypes  = is_array($request->sub_vendor_types) ? json_encode($request->sub_vendor_types) : $request->sub_vendor_types;

        // ✅ Create project
        $project = Project::create([
            'full_name'        => $request->full_name,
            'phone_number'     => $request->phone_number,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'role_id'          => $request->role_id,

            'site_ready'       => $request->has('site_ready'),
            'land_location'    => $request->land_location,
            'survey_number'    => $request->survey_number,
            'land_type'        => $request->land_type,
            'land_area'        => $request->land_area,
            'land_unit'        => $request->land_unit,

            'arch_drawings'    => $request->has('arch_drawings'),
            'struct_drawings'  => $request->has('struct_drawings'),
            'has_boq'          => $request->has('has_boq'),
            'boq_file'         => $boqPath,
            'expected_start'   => $request->expected_start,
            'project_duration' => $request->project_duration,
            'budget_range'     => $request->budget_range,
            'site_status'      => $request->site_status,
            'floors'           => $request->floors,
            'water'            => $request->water,
            'electricity'      => $request->electricity,
            'drainage'         => $request->drainage,
            'payment_preference'=> $request->payment_preference,
            'quality_preference'=> $request->quality_preference,
            'vendor_preference'=> $request->vendor_preference,
            'best_time'        => $request->best_time,

            // ✅ Store converted arrays
            'work_type'        => $workType,
            'work_subtype'     => $workSubtype,
            'vendor_type'      => $vendorType,
            'sub_vendor_types' => $subVendorTypes,


            'region'        => $request->region,
            'city'        => $request->city,
            'state'           => $request->state,
            // ✅ Save JSON file paths
            'arch_files'       => !empty($archPaths) ? json_encode($archPaths) : null,
            'struct_files'     => !empty($structPaths) ? json_encode($structPaths) : null,
        ]);

        session(['current_project_id' => $project->id]);

        return response()->json([
            'success'  => true,
            'redirect' => route('project_details'),
        ]);
    }


public function project_details()
{
    $projectId = session('current_project_id');

    if (!$projectId) {
        return redirect('/')->with('error', 'No project found in session.');
    }

    $project = DB::table('projects')->where('id', $projectId)->first();

    if (!$project) {
        return redirect('/')->with('error', 'Project not found.');
    }

    // Default state
    $showFullAddons = false;

    // ✅ Apply same logic for work_type 1 and 4
    if (in_array($project->work_type, [1, 4])) {
        if (
            $project->arch_drawings == 0 ||
            $project->struct_drawings == 0 ||
            $project->has_boq == 0
        ) {
            $showFullAddons = true;
        }
    }

    // dd($showFullAddons);

    return view('web.project_details', compact('project', 'showFullAddons'));
}


  public function project_details_save(Request $request)
{
    $projectId = session('current_project_id');

    // Step 1: Validate incoming request
    $request->validate([
        'project_name' => 'required|string',
        'project_description' => 'nullable|string',
        'file_path.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
    ]);

    // Step 2: Handle missing session project ID
    if (!$projectId) {
        return response()->json([
            'success' => false,
            'message' => 'No active project found in session.'
        ], 400);
    }

    // Step 3: Get last record safely (can be null)
    $lastProject = DB::table('projects_details')->latest('id')->first();

    // Step 4: Prevent "read property on null"
    $pro_id = $lastProject ? $lastProject->id + 1 : 1;

    // Step 5: Handle file upload
    $filePaths = [];
    if ($request->hasFile('file_path')) {
        foreach ($request->file('file_path') as $file) {
            $path = $file->store('file_path', 'public');
            $filePaths[] = $path;
        }
    }

    // Step 6: Generate unique submission ID
    $submission_id = 'PI/' . date('Y') . '/' . str_pad($pro_id, 6, '0', STR_PAD_LEFT);

    // Step 7: Insert new project detail
    $newProjectId = DB::table('projects_details')->insertGetId([
        'project_id' => $projectId,
        'submission_id' => $submission_id,
        'project_name' => $request->project_name,
        'project_description' => $request->project_description,
        'file_path' => !empty($filePaths) ? json_encode($filePaths) : null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Step 8: Return success response
    return response()->json([
        'success' => true,
        'project_id' => $newProjectId,
        'submission_id' => $submission_id,
    ]);
}

    // public function project_details_save(Request $request)
    // {
    //     $projectId = session('current_project_id');
    //     $lastProject = DB::table('projects_details')->latest('id')->first();
        
    //      $pro_id = $lastProject ? $lastProject->id + 1 : 1;
         
    //     // dd($pro_id);
    //     $pro_id = $lastProject->id;
    //     $request->validate([
    //         'project_name' => 'required|string',
    //         'project_description' => 'nullable|string',
    //         'file_path.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
    //     ]);

    //     $filePaths = [];

    //     // Handle file upload first
    //     if ($request->hasFile('file_path')) {
    //         foreach ($request->file('file_path') as $file) {
    //             $path = $file->store('file_path', 'public'); // store in storage/app/public/project_files
    //             $filePaths[] = $path;
    //         }
    //     }

    //     // $submission_id = 'PI'.'/'.$projectId;
    //     $submission_id = 'PI/' . date('Y') . '/' . str_pad($pro_id, 6, '0', STR_PAD_LEFT);

    //     // Insert project into DB
    //     $projectId = DB::table('projects_details')->insertGetId([
    //         'project_id' => $projectId,
    //         'submission_id' =>$submission_id ,
    //         'project_name' => $request->project_name,
           
    //         'project_description' => $request->project_description,
    //         'file_path' => !empty($filePaths) ? json_encode($filePaths) : null, 
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return response()->json(['success' => true, 'project_id' => $projectId,'submission_id' => $submission_id]);
    // }

    public function customer_dashboard()
    {
        $user = session('user'); // ✅ user from login
       
        $projectId = session('current_project_id'); // ✅ project from form (optional)

        $projectKey = $projectId ?: $user->id;
        // ✅ Always fetch customer details by user_id (same as project_id)
        $cust_details = DB::table('projects')
                            ->where('id', $projectKey)
                            ->first();
// dd($cust_details);
        $projects = DB::table('projects_details')
                        ->where('project_id', $projectKey)
                        ->get();
// dd($projects);

        $vendors = DB::table('business_registrations')
                ->where('user_id', '11')
                ->get();

        $states = DB::table('states')->where('is_active',1)->get(); 
        $role_types = DB::table('role')->get();

        $company_socials = [
                'facebook'  => 'https://www.facebook.com/share/16n2rF5yTV/?mibextid=wwXIfr',
                'linkedin'  => 'https://linkedin.com/company/ConstructKaro',
                'instagram' => 'https://www.instagram.com/constructkaro?igsh=MTZmb3Jxajd3N3lhNg==',
            ];
    // dd($states);
        return view('web.customer_dashboard', compact('projects', 'cust_details', 'projectKey','vendors','states','role_types','company_socials'));
    }


    
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
// dd($vendor_details);
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

public function viewProject($encryptedId)
{
    try {
        // 🔒 Decrypt the ID safely
        $id = decrypt($encryptedId);
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        // If tampered or invalid link
        return redirect()->route('customer.dashboard')->with('error', 'Invalid project link.');
    }
// dd($id);
    // ✅ Fetch project safely
    $project = DB::table('projects_details')->find($id);
// dd($project);
    if (!$project) {
        return redirect()->route('customer.dashboard')->with('error', 'Project not found.');
    }

    // ✅ Fetch project details
    $projcet_details = DB::table('projects_details')
        ->where('id', $project->id)
        ->first();

    $p_id = $projcet_details->project_id;

    // ✅ Fetch customer details using project_id (user_id)
    $cust_details = DB::table('projects')
        ->where('id', $p_id)
        ->first();

    return view('web.customer_project_details', compact('project', 'cust_details','projcet_details'));
}

public function updateProfile(Request $request)
{
    
    $user = $request->project_id; // or fetch via $cust_details if separate table
// dd($user);
    // ✅ Validate incoming data
    $validated = $request->validate([
        'phone_number' => 'nullable|string|max:15',
        'role_id' => 'nullable|string|max:100',
        'gender' => 'nullable|string|max:10',
        'gst_no' => 'nullable|string|max:20',
        'gst_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'tds_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'state' => 'nullable|integer',
        'region' => 'nullable|integer',
        'city' => 'nullable|integer',
        'facebook' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'instagram' => 'nullable|url',
    ]);

    // ✅ File uploads
    if ($request->hasFile('gst_certificate')) {
        $validated['gst_certificate'] = $request->file('gst_certificate')->store('certificates', 'public');
    }

    if ($request->hasFile('tds_certificate')) {
        $validated['tds_certificate'] = $request->file('tds_certificate')->store('certificates', 'public');
    }

    if ($request->hasFile('profile_photo')) {
        $validated['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
    }

    // ✅ Update in your DB table
    DB::table('projects')
        ->where('id', $user)
        ->update($validated);

    return redirect()->back()->with('success', 'Profile updated successfully!');
}


}