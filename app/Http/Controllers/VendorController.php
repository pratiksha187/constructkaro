<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\BusinessRegistration;
use Illuminate\Support\Facades\Hash;
use App\Models\ProjectDetails;
use Illuminate\Support\Facades\Storage;
use App\Models\AgencyService;
use App\Models\TenderDocument;
use Illuminate\Validation\Rule;
use App\Models\ProjectLike;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    public function vendor()
    {
         $states = DB::table('states')->where('is_active',1)->get(); 
        return view('web.vendor',compact('states')); // View file created below
    }

   
    public function registerServiceProvider(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'          => ['required','string','max:255'],
            'mobile'        => ['required','digits:10','unique:service_provider,mobile'],
            'email'         => ['required','email:rfc,dns','unique:service_provider,email'],
            'business_name' => ['nullable','string','max:255'],
            'gst_number'    => ['nullable','string','max:50'],
            'state'      => ['required'],
            'city'      => ['required'],
            'region'      => ['required'],
            'password'      => ['required','confirmed','min:8'],
        ],[
            'mobile.unique'      => 'This mobile number is already registered.',
            'email.unique'       => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Create vendor first
        $vendor = ServiceProvider::create([
            'name'          => $request->name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'business_name' => $request->business_name,
            'gst_number'    => $request->gst_number,
            'state'      => $request->state,
             'city'      => $request->city,
              'region'      => $request->region,
            'password'      => Hash::make($request->password),
        ]);

        // Generate vendor code: SP/YYYY/ID
        $vendorCode = 'SP/' . date('Y') . '/' . str_pad($vendor->id, 2, '0', STR_PAD_LEFT);

        // Save vendor code back to DB
        $vendor->update(['vendor_code' => $vendorCode]);

        // Store in session
        session(['vendor_id' => $vendor->id, 'vendor_code' => $vendorCode]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.',
            'vendor_code' => $vendorCode
        ], 200);
    }

    public function types_of_agency()
    {
        $agencyTypes = DB::table('work_subtypes')->get();
         $workTypes = DB::table('work_types')->get();
        // dd($agencyTypes);
        return view('web.types_of_agency', compact('agencyTypes','workTypes'));
    }

    
    public function save_agency_services(Request $request)
    {
        $validated = $request->validate([
            'work_type' => 'required|integer',
            'work_subtype' => 'required|array',
            'work_subtype.*' => 'integer',

            'vendor_type' => 'required|array',
            'vendor_type.*' => 'array',          // each project id has an array of vendor ids
            'vendor_type.*.*' => 'integer',      // validate vendor ids inside each project

            'sub_vendor_types' => 'nullable|array',
        ]);

        $vendor_id = session('vendor_id') ?? auth()->id();

        AgencyService::create([
            'user_id'          => $vendor_id,
            'work_type_id'     => $validated['work_type'],
            'work_subtype_id'  => json_encode($validated['work_subtype']), // array of subtype ids
            'vendor_type_id'   => json_encode($validated['vendor_type']),  // nested array (grouped by subtype)
            'sub_vendor_types' => json_encode($request->input('sub_vendor_types', [])), // nested array
        ]);

        return response()->json(['status' => 'success', 'message' => 'Saved successfully']);
    }


     public function about_business(){
        $states = DB::table('states')->where('is_active',1)->get(); 
        $entity_type = DB::table('entity_type')->get(); 
        return view('web.about_vendor_business',compact('entity_type','states'));
    }

     public function getServices($agency_id)
    {
        $services = DB::table('suggested_vendor_types')
            ->where('work_subtype_id', $agency_id)
            ->pluck('vendor_type', 'id');
// dd($services);
        return response()->json($services);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file'  => 'required|file|mimes:pdf|max:20480', 
            'field' => 'required|string'
        ]);

        $path = $request->file('file')->store('vendor_docs', 'public');

        return response()->json(['path' => $path], 200);
    }
 


    // public function business_store(Request $request)
    // {
    //     dd($_POST);
    //     $validated = $request->validate([
    //         'experience_years'           => 'required|numeric',
    //         'team_size'                  => 'required|numeric',
    //         'min_project_value'          => 'required|numeric',
    //         'company_name'               => 'required|string',
    //         'entity_type'                => 'required|string', 
    //         'registered_address'         => 'required|string',
    //         'contact_person_designation' => 'required|string',
    //         'gst_number'                 => 'required|string',
    //         'pan_number'                 => 'required|string',
    //         'tan_number'                 => 'nullable|string',
    //         'esic_number'                => 'nullable|string',
    //         'pf_code'                    => 'nullable|string',
    //         'msme_registered'            => ['required', Rule::in(['yes','no'])],
    //         'bank_name'                  => 'string',
    //         'account_number'             => 'string',
    //         'ifsc_code'                  => 'string',
    //         'account_type'               => 'string',
    //         'agreed_declaration'         => 'required', 
    //         'llpin_no'                   => 'nullable|string',
    //         'state'                      => 'required', 
    //         'region'                     => 'required', 
    //         'city'                       => 'nullable', 
    //         'client_name' => 'required',
    //         'organization' => 'required', 
    //         'phone' => 'required', 
    //         'email' => 'required', 
    //         // Single files
    //         'cancelled_cheque_file'               => 'nullable|file|mimes:pdf|max:20480',
    //         'pan_card_file'                       => 'nullable|file|mimes:pdf|max:20480',
    //         'aadhaar_card_file'                   => 'nullable|file|mimes:pdf|max:20480',
    //         'certificate_of_incorporation_file'   => 'nullable|file|mimes:pdf|max:20480',
    //         'itr_file'                            => 'nullable|file|mimes:pdf|max:40960',
    //         'turnover_certificate_file'           => 'nullable|file|mimes:pdf|max:20480',
    //         'work_completion_certificates_file'   => 'nullable|file|mimes:pdf|max:40960',
    //         'pf_documents_file'                   => 'nullable|file|mimes:pdf|max:20480',
    //         'epic_documents_file'                 => 'nullable|file|mimes:pdf|max:20480',
    //         'company_profile_file'                => 'nullable|file|mimes:pdf|max:40960',
    //         'portfolio_file'                      => 'nullable|file|mimes:pdf|max:40960',
    //         'license_certificate_file'            => 'nullable|file|mimes:pdf|max:20480',
    //         'uploadadharpanFile'                  => 'nullable|file|mimes:pdf|max:20480',

    //         // Multiple files
    //         'past_work_photos'                     => 'nullable',
    //         'past_work_photos.*'                   => 'file|image|mimes:jpeg,png,jpg,gif|max:10240',
    //     ]);

    //     $userId = session('vendor_id');

    //     // --- Handle single file uploads ---
    //     $singleFiles = [
    //         'cancelled_cheque_file','pan_card_file','aadhaar_card_file',
    //         'certificate_of_incorporation_file','itr_file','turnover_certificate_file',
    //         'work_completion_certificates_file','pf_documents_file','epic_documents_file',
    //         'company_profile_file','portfolio_file','license_certificate_file','uploadadharpanFile'
    //     ];

    //     $uploadedFiles = [];
    //     foreach ($singleFiles as $field) {
    //         if ($request->hasFile($field)) {
    //             $uploadedFiles[$field] = $request->file($field)->store('vendor_docs', 'public');
    //         }
    //     }

    //     // --- Handle multiple past work photos ---
    //     if ($request->hasFile('past_work_photos')) {
    //         $pastPhotos = [];
    //         foreach ($request->file('past_work_photos') as $file) {
    //             $pastPhotos[] = $file->store('vendor_docs/past_photos', 'public');
    //         }
    //         $uploadedFiles['past_work_photos'] = json_encode($pastPhotos);
    //     }

    //     // --- Build DB payload ---
    //     $payload = [
    //         'experience_years'            => $validated['experience_years'],
    //         'team_size'                   => $validated['team_size'],
    //         'min_project_value'           => $validated['min_project_value'],
    //         'company_name'                => $validated['company_name'],
    //         'entity_type'                 => $validated['entity_type'],
    //         'registered_address'          => $validated['registered_address'],
    //         'contact_person_designation'  => $validated['contact_person_designation'],
    //         'gst_number'                  => $validated['gst_number'],
    //         'pan_number'                  => $validated['pan_number'],
    //         'tan_number'                  => $validated['tan_number'] ?? null,
    //         'esic_number'                 => $validated['esic_number'] ?? null,
    //         'pf_code'                     => $validated['pf_code'] ?? null,
    //         'msme_registered'             => $validated['msme_registered'],
    //         'bank_name'                   => $validated['bank_name'],
    //         'account_number'              => $validated['account_number'],
    //         'ifsc_code'                   => $validated['ifsc_code'],
    //         'account_type'                => $validated['account_type'],
    //         'agreed_declaration'          => $request->boolean('agreed_declaration') ? 1 : 0,
    //         'llpin_no'                    => $validated['llpin_no'] ?? null,
    //         'user_id'                     => $userId,
    //         'past_work_photos'            => $uploadedFiles['past_work_photos'] ,
    //         'state'                       => is_array($validated['state']) ? json_encode($validated['state']) : $validated['state'],
    //         'region'                      => is_array($validated['region']) ? json_encode($validated['region']) : $validated['region'],
    //         // 'city'                        => is_array($validated['city']) ? json_encode($validated['city']) : $validated['city'],
    //         'client_name'                 => json_encode($validated['client_name']),
    //         'organization'                => json_encode($validated['organization']),
    //         'phone'                       => json_encode($validated['phone']),
    //         'email'                       => json_encode($validated['email']),
    //         'cancelled_cheque_file'       => $uploadedFiles['cancelled_cheque_file'],
    //         'approved'                    => 0,
    //         'created_at'                  => now(),
    //         'updated_at'                  => now(),
    //     ];

    //     // Merge uploaded file paths
    //     $payload = array_merge($payload, $uploadedFiles);
    //     // dd($payload);
    //     DB::table('business_registrations')->insert($payload);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Business registration saved successfully!'
    //     ], 200);
    // }

    public function business_store(Request $request)
    {
        // 🔹 Validate input
        $validated = $request->validate([
            'experience_years'           => 'required|numeric',
            'team_size'                  => 'required|numeric',
            'min_project_value'          => 'required|numeric',
            'company_name'               => 'required|string',
            'entity_type'                => 'required|string', 
            'registered_address'         => 'required|string',
            'contact_person_designation' => 'required|string',
            'gst_number'                 => 'required|string',
            'pan_number'                 => 'required|string',
            'tan_number'                 => 'nullable|string',
            'esic_number'                => 'nullable|string',
            'pf_code'                    => 'nullable|string',
            'msme_registered'            => ['required', Rule::in(['yes','no'])],
            'bank_name'                  => 'nullable|string',
            'account_number'             => 'nullable|string',
            'ifsc_code'                  => 'nullable|string',
            'account_type'               => 'nullable|string',
            'agreed_declaration'         => 'required',
            'llpin_no'                   => 'nullable|string',
            'state'                      => 'required',
            'region'                     => 'required',
            'client_name'                => 'required|array',
            'organization'               => 'required|array',
            'phone'                      => 'required|array',
            'email'                      => 'required|array',
            'year_of_completion'         => 'required|array',

            // Single file uploads
            'cancelled_cheque_file'               => 'nullable|file|mimes:pdf|max:20480',
            'pan_card_file'                       => 'nullable|file|mimes:pdf|max:20480',
            'aadhaar_card_file'                   => 'nullable|file|mimes:pdf|max:20480',
            'certificate_of_incorporation_file'   => 'nullable|file|mimes:pdf|max:20480',
            'itr_file'                            => 'nullable|file|mimes:pdf|max:40960',
            // 'turnover_certificate_file'           => 'nullable|file|mimes:pdf|max:20480',
            'work_completion_certificates_file1'  => 'nullable|file|mimes:pdf|max:20480',
            'work_completion_certificates_file2'  => 'nullable|file|mimes:pdf|max:20480',
            'work_completion_certificates_file3'  => 'nullable|file|mimes:pdf|max:20480',
            'pf_documents_file'                   => 'nullable|file|mimes:pdf|max:20480',
            'esic_documents_file'                 => 'nullable|file|mimes:pdf|max:20480',
            'company_profile_file'                => 'nullable|file|mimes:pdf|max:40960',
            'portfolio_file'                      => 'nullable|file|mimes:pdf|max:40960',
            'license_certificate_file'            => 'nullable|file|mimes:pdf|max:20480',
            'uploadadharpanFile'                  => 'nullable|file|mimes:pdf|max:20480',

            // Multiple files
            'past_work_photos'                    => 'nullable',
            'past_work_photos.*'                  => 'file|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $userId = session('vendor_id');
// turnover_certificate_file
        // 🔹 Handle single file uploads
        $singleFiles = [
            'cancelled_cheque_file', 'pan_card_file', 'aadhaar_card_file',
            'certificate_of_incorporation_file', 'itr_file', 
            'work_completion_certificates_file1', 'work_completion_certificates_file2',
            'work_completion_certificates_file3', 'pf_documents_file', 'esic_documents_file',
            'company_profile_file', 'portfolio_file', 'license_certificate_file', 'uploadadharpanFile'
        ];

        $uploadedFiles = [];
        foreach ($singleFiles as $field) {
            if ($request->hasFile($field)) {
                $uploadedFiles[$field] = $request->file($field)->store('vendor_docs', 'public');
            } else {
                $uploadedFiles[$field] = null;
            }
        }

        // 🔹 Handle multiple past work photos
        if ($request->hasFile('past_work_photos')) {
            $pastPhotos = [];
            foreach ($request->file('past_work_photos') as $file) {
                $pastPhotos[] = $file->store('vendor_docs/past_photos', 'public');
            }
            $uploadedFiles['past_work_photos'] = json_encode($pastPhotos);
        } else {
            $uploadedFiles['past_work_photos'] = null;
        }

        // 🔹 Build DB payload
        $payload = [
            'user_id'                    => $userId,
            'experience_years'           => $validated['experience_years'],
            'team_size'                  => $validated['team_size'],
            'min_project_value'          => $validated['min_project_value'],
            'company_name'               => $validated['company_name'],
            'entity_type'                => $validated['entity_type'],
            'registered_address'         => $validated['registered_address'],
            'contact_person_designation' => $validated['contact_person_designation'],
            'gst_number'                 => $validated['gst_number'],
            'pan_number'                 => $validated['pan_number'],
            'tan_number'                 => $validated['tan_number'] ?? null,
            'esic_number'                => $validated['esic_number'] ?? null,
            'pf_code'                    => $validated['pf_code'] ?? null,
            'msme_registered'            => $validated['msme_registered'],
            'bank_name'                  => $validated['bank_name'] ?? null,
            'account_number'             => $validated['account_number'] ?? null,
            'ifsc_code'                  => $validated['ifsc_code'] ?? null,
            'account_type'               => $validated['account_type'] ?? null,
            'agreed_declaration'         => $request->boolean('agreed_declaration') ? 1 : 0,
            'llpin_no'                   => $validated['llpin_no'] ?? null,
            'state'                      => is_array($validated['state']) ? json_encode($validated['state']) : $validated['state'],
            'region'                     => is_array($validated['region']) ? json_encode($validated['region']) : $validated['region'],
            'client_name'                => json_encode($validated['client_name']),
            'organization'               => json_encode($validated['organization']),
            'phone'                      => json_encode($validated['phone']),
            'email'                      => json_encode($validated['email']),
            'year_of_completion'         => json_encode($validated['year_of_completion']),
            'past_work_photos'           => $uploadedFiles['past_work_photos'],
            'approved'                   => 0,
            'created_at'                 => now(),
            'updated_at'                 => now(),
        ];

        // 🔹 Merge uploaded file paths into payload
        $payload = array_merge($payload, $uploadedFiles);

        // 🔹 Save to DB
        DB::table('business_registrations')->insert($payload);

        return response()->json([
            'status' => true,
            'message' => 'Business registration saved successfully!'
        ], 200);
    }

    public function vendor_confiermetion()
    {
        $vendor_id = session('vendor_id');

        $vendor_details = DB::table('service_provider')
            ->where('id', $vendor_id)
            ->first();

        return view('web.vendor_confiermetion', [
            'vendor' => $vendor_details
        ]);
    }

    public function showListPage()
    {
        return view('web.list_of_project');
    }

    public function projectsData(Request $request)
    {
        $query = projectDetails::query()
                    ->where('boq_status', 1)
                    ->where('tender_status', 1);
        if ($request->filled('project_name')) {
            $query->where('project_name', 'like', '%' . $request->project_name . '%');
        }

        if ($request->filled('budget_range')) {
            $query->where('budget_range', 'like', '%' . $request->budget_range . '%');
        }

        return DataTables::of($query)->make(true);
    }

    public function vendor_likes_project()
    {
        $vendor_id = session('vendor_id');

        $vendor_details = DB::table('service_provider')
            ->where('id', $vendor_id)
            ->first();
        return view('web.vendor_likes_project',[
            'vendor' => $vendor_details
        ]);
    }

    public function likeprojectsData(Request $request)
    {
        // dd($request);
        $vendorId = session('vendor_id');
        // dd($vendorId);
        // Join with projects_details table to get project information
        $query = DB::table('project_likes')
            ->join('projects_details', 'project_likes.project_id', '=', 'projects_details.id')
            ->where('project_likes.vendor_id', $vendorId)
            ->select(
                'projects_details.project_name',
                'projects_details.budget_range',
                'projects_details.expected_timeline',
                'projects_details.id'
            );
        if ($request->project_name) {
            $query->where('projects_details.project_name', 'like', '%' . $request->project_name . '%');
        }

        if ($request->budget_range) {
            $query->where('projects_details.budget_range', 'like', '%' . $request->budget_range . '%');
        }

        return DataTables::of($query)->make(true);
    }

    public function vendor_dashboard() {
        $vendor_id = session('vendor_id');
        $vendor = DB::table('service_provider')->where('id', $vendor_id)->first(); 

        $project_details = DB::table('business_registrations')
                            ->where('user_id', $vendor->id) 
                            ->get();

        $project_details_count = $project_details->count();

    
        $projects_by_month = DB::table('business_registrations')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
        ->where('user_id', $vendor->id)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');



        return view('web.vendor_dashboard', compact(
            'vendor_id',
            'vendor',
            'project_details',
            'project_details_count',
            'projects_by_month'
        ));
    }

    public function projectlikes(Request $request)
    {
        $vendor_id = session('vendor_id');
        $request->validate([
            'project_id' => 'required',
        ]);

        $alreadyLiked = ProjectLike::where('project_id', $request->project_id)
                        ->where('vendor_id', $vendor_id)
                        ->exists();

        if ($alreadyLiked) {
            return response()->json(['message' => 'You already liked this project.'], 409); 
        }

        ProjectLike::create([
            'project_id' => $request->project_id,
            'vendor_id' => $vendor_id,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Like recorded!']);
    }

    public function projectshow($id)
    {
        $project = ProjectDetails::findOrFail($id);

        return response()->json([
            'project_name' => $project->project_name,
            'budget_range' => $project->budget_range,
            'expected_timeline' => $project->expected_timeline,
        ]);
    }

    public function uploadFiletenderdocuments(Request $request)
    {
        // Basic presence
        $request->validate([
            'field' => 'required',
            'file'  => 'required|file',
        ]);

        // Make sure $field is a plain string (not Stringable/array)
        $field = (string) $request->input('field');

        // Only allow known fields
        $allowed = [
            'emd_receipt'        => 'file|mimes:pdf|max:20480',
            'company_profile'    => 'file|mimes:pdf|max:40960',
            'address_proof'      => 'file|mimes:pdf|max:20480',
            'gst_certificate'    => 'file|mimes:pdf|max:20480',
            'work_experience'    => 'file|mimes:pdf|max:40960',
            'financial_capacity' => 'file|mimes:pdf|max:40960',
            'declaration'        => 'file|mimes:pdf|max:20480',
            'boq_file'           => 'file|mimes:xls,xlsx|max:51200',
        ];

        if (! array_key_exists($field, $allowed)) {
            return response()->json(['message' => 'Invalid field name.'], 422);
        }

        // Validate the file using the rule for this field
        $request->validate(['file' => $allowed[$field]]);

        // Choose directory
        $dir  = $field === 'boq_file' ? 'tenders/boq' : 'tenders/pdfs';
        $path = $request->file('file')->store($dir, 'public'); // php artisan storage:link

        return response()->json(['field' => $field, 'path' => $path], 200);
    }
    
    public function storeTenderDocuments(Request $request)
    {
        $vendor_id = session('vendor_id') ?? auth()->id();

        $request->validate([
            'project_id'   => 'required|exists:projects_details,id',
            'vendor_cost'  => 'required|numeric|min:0',
            'uploaded_paths' => 'required|string', // JSON from the front-end
        ]);

        $paths = json_decode($request->uploaded_paths, true);
        if (!is_array($paths)) {
            return response()->json(['message' => 'Invalid uploaded_paths'], 422);
        }

        // Safety: ensure all non-BOQ are .pdf, BOQ is xls/xlsx
        foreach ($paths as $field => $relPath) {
            if (!is_string($relPath)) continue;
            $lower = strtolower($relPath);
            if ($field === 'boq_file') {
                if (!str_ends_with($lower, '.xls') && !str_ends_with($lower, '.xlsx')) {
                    return response()->json(['message' => 'BOQ must be .xls/.xlsx'], 422);
                }
            } else {
                if (!str_ends_with($lower, '.pdf')) {
                    return response()->json(['message' => "$field must be a PDF"], 422);
                }
            }
        }

        TenderDocument::create(array_merge([
            'project_id'  => $request->project_id,
            'vendor_id'   => $vendor_id,
            'vendor_cost' => $request->vendor_cost,
        ], $paths));

        return response()->json(['message' => 'Tender documents uploaded successfully!'], 200);
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2',
        ]);
        $vendor = BusinessRegistration::findOrFail($id);
        $vendor->approved = $request->status;
        $vendor->save();

        return response()->json(['message' => 'Vendor status updated successfully.']);
    }


    public function followUpdate(Request $request)
    {
        $vendorId = $request->vendor_id;
        // dd($vendorId);
        $vendor = DB::table('service_provider')->where('id', $vendorId)->first();
        if(!$vendor){
            return response()->json(['status' => 'error']);
        }

        // Example: Update a column like `has_followed` to 1
        DB::table('service_provider')->where('id', $vendorId)->update([
            'has_followed' => 1,
            'updated_at' => now()
        ]);

        return response()->json(['status' => 'success']);
    }


    public function vendor_terms_condition(){
        $vendor_id = session('vendor_id');

        $vednor_details=DB::table('service_provider')->where('id', $vendor_id)->first();
        $get_agency_services = DB::table('agency_services')->where('user_id', $vendor_id)->first();
        $work_id = $get_agency_services->work_type_id;

        $vednor_comp_details=DB::table('business_registrations')->where('user_id', $vendor_id)->first();
        
        $workTypes_name = DB::table('work_types')->where('id', $work_id)->first();

        // dd($vednor_comp_details);
        return view('web.vendor_terms_condition',compact('vendor_id','vednor_details','get_agency_services','work_id','workTypes_name','vednor_comp_details'));
    }
}
