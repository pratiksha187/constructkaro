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

class VendorController extends Controller
{
    public function vendor()
    {
        return view('web.vendor'); // View file created below
    }

    public function registerServiceProvider(Request $request)
    {
       
         $validator = Validator::make($request->all(), [
            'name'                  => ['required','string','max:255'],
            'mobile'                => ['required','digits:10','unique:service_provider,mobile'],
            'email'                 => ['required','email:rfc,dns','unique:service_provider,email'],
            'business_name'         => ['nullable','string','max:255'],
            'gst_number'            => ['nullable','string','max:50'],
            'location'              => ['required','max:255'],
            'password'              => ['required','confirmed','min:8'],
        ],[
            'mobile.unique'         => 'This mobile number is already registered.',
            'email.unique'          => 'This email is already registered.',
            'password.confirmed'    => 'Passwords do not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $vendor = ServiceProvider::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'business_name' => $request->business_name,
            'gst_number' => $request->gst_number,
            // 'location' => $request->location,
            'location' => json_encode($request->location),

            'password' => Hash::make($request->password),
        ]);

        session(['vendor_id' => $vendor->id]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.'
        ], 200);
    }

    public function types_of_agency()
    {
        $agencyTypes = DB::table('agency_types')->get();
        return view('web.types_of_agency', compact('agencyTypes'));
    }

    public function save_agency_services(Request $request)
    {
        $validated = $request->validate([
            'agency_type' => 'required|string',
            'services' => 'required|array',
            'other_service' => 'nullable|string|max:255'
        ]);

        $vendor_id = session('vendor_id');

        AgencyService::create([
            'user_id' => $vendor_id,
            'agency_type' => $validated['agency_type'],
            'services' => json_encode($validated['services']),
            'other_service' => $validated['other_service'] ?? null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Saved successfully']);
    }

     public function about_business(){
        $entity_type = DB::table('entity_type')->get(); 
         return view('web.about_vendor_business',compact('entity_type'));
    }

     public function getServices($agency_id)
    {
        $services = DB::table('services')
            ->where('agency_id', $agency_id)
            ->pluck('name', 'id');

        return response()->json($services);
    }

   public function uploadFile(Request $request)
    {
        $request->validate([
            'file'  => 'required|file|mimes:pdf|max:20480', // 20 MB (change if needed)
            'field' => 'required|string'
        ]);

        // store to public disk so it’s accessible via /storage
        // run once: php artisan storage:link
        $path = $request->file('file')->store('vendor_docs', 'public');

        return response()->json(['path' => $path], 200);
    }
 
    //   public function business_store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'experience_years' => 'required|string',
    //         'team_size' => 'required|string',
    //         'service_coverage_area' => 'required|string',
    //         'min_project_value' => 'required|numeric',
    //         'company_name' => 'required|string',
    //         'entity_type' => 'required|string',
    //         'registered_address' => 'required|string',
    //         'contact_person_designation' => 'required|string',
    //         'gst_number' => 'required|string',
    //         'pan_number' => 'required|string',
    //         'tan_number' => 'nullable|string',
    //         'esic_number' => 'nullable|string',
    //         'pf_code' => 'nullable|string',
    //         'msme_registered' => 'required|string',
    //         // 'pan_aadhar_seeded' => 'required|string',
    //         'bank_name' => 'required|string',
    //         'account_number' => 'required|string',
    //         'ifsc_code' => 'required|string',
    //         'account_type' => 'required|string',
    //         'cancelled_cheque_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'pan_card_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'aadhaar_card_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'certificate_of_incorporation_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'itr_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'turnover_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'work_completion_certificates_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'pf_esic_documents_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'company_profile_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'portfolio_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'past_work_photos_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'license_certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'aadhar_section' =>'nullable',
    //         'cin_section' => 'nullable',
    //         'llpin_no' => 'nullable|string',
    //         'uploadadharpanFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    //         'agreed_declaration' => 'nullable',

    //     ]);
       
    //     $vendor_id = session('vendor_id');
    //     $approved = 0;
    //     $validated['user_id'] = $vendor_id;
    //     $validated['approved'] = $approved;
       
       
    //     $fileFields = [
    //             'cancelled_cheque_file', 'pan_card_file', 'aadhaar_card_file',
    //             'certificate_of_incorporation_file', 'itr_file', 'turnover_certificate_file',
    //             'work_completion_certificates_file', 'pf_esic_documents_file',
    //             'company_profile_file', 'portfolio_file', 'past_work_photos_file',
    //             'license_certificate_file', 'uploadadharpanFile'
    //         ];


    //     foreach ($fileFields as $field) {
    //         if ($request->hasFile($field)) {
    //             $validated[$field] = $request->file($field)->store('documents', 'public');
    //         }
    //     }

    //     BusinessRegistration::create($validated);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Business registration data saved successfully!'
    //     ]);
    // }
 public function business_store(Request $request)
    {
        // ---- VALIDATION (non-file fields) ----
        $validated = $request->validate([
            'experience_years'          => 'required|string',
            'team_size'                 => 'required|string',
            'service_coverage_area'     => 'required|string',
            'min_project_value'         => 'required|numeric',
            'company_name'              => 'required|string',
            'entity_type'               => 'required|string',
            'registered_address'        => 'required|string',
            'contact_person_designation'=> 'required|string',
            'gst_number'                => 'required|string',
            'pan_number'                => 'required|string',
            'tan_number'                => 'nullable|string',
            'esic_number'               => 'nullable|string',
            'pf_code'                   => 'nullable|string',
            'msme_registered'           => ['required', Rule::in(['yes','no'])],
            'bank_name'                 => 'required|string',
            'account_number'            => 'required|string',
            'ifsc_code'                 => 'required|string',
            'account_type'              => 'required|string',
            // if you want the checkbox mandatory, change to 'accepted'
            'agreed_declaration'        => 'nullable',
            // optional UI flags
            'aadhar_section'            => 'nullable',
            'cin_section'               => 'nullable',
            'llpin_no'                  => 'nullable|string',

            // OPTIONAL: if you still allow direct uploads in this final POST,
            // keep these rules as PDF-only:
            'cancelled_cheque_file'               => 'nullable|file|mimes:pdf|max:20480',
            'pan_card_file'                       => 'nullable|file|mimes:pdf|max:20480',
            'aadhaar_card_file'                   => 'nullable|file|mimes:pdf|max:20480',
            'certificate_of_incorporation_file'   => 'nullable|file|mimes:pdf|max:20480',
            'itr_file'                            => 'nullable|file|mimes:pdf|max:40960', // 40MB (ITR can be big)
            'turnover_certificate_file'           => 'nullable|file|mimes:pdf|max:20480',
            'work_completion_certificates_file'   => 'nullable|file|mimes:pdf|max:40960',
            'pf_esic_documents_file'              => 'nullable|file|mimes:pdf|max:20480',
            'company_profile_file'                => 'nullable|file|mimes:pdf|max:40960',
            'portfolio_file'                      => 'nullable|file|mimes:pdf|max:40960',
            'past_work_photos_file'               => 'nullable|file|mimes:pdf|max:40960',
            'license_certificate_file'            => 'nullable|file|mimes:pdf|max:20480',
            'uploadadharpanFile'                  => 'nullable|file|mimes:pdf|max:20480',

            // Sequential upload map (JSON)
            'uploaded_paths'             => 'nullable|string'
        ]);

        // ---- VENDOR + APPROVAL ----
        $vendor_id = session('vendor_id');
        $validated['user_id'] = $vendor_id;
        $validated['approved'] = 0;

        // ---- COLLECT FILE PATHS ----
        // 1) Paths from sequential uploads (uploaded_paths JSON)
        $pathsFromJson = json_decode($request->input('uploaded_paths', '{}'), true) ?: [];

        // 2) Also support direct uploads on this same request (backward compatible)
        $fileFields = [
            'cancelled_cheque_file', 'pan_card_file', 'aadhaar_card_file',
            'certificate_of_incorporation_file', 'itr_file', 'turnover_certificate_file',
            'work_completion_certificates_file', 'pf_esic_documents_file',
            'company_profile_file', 'portfolio_file', 'past_work_photos_file',
            'license_certificate_file', 'uploadadharpanFile'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // store direct file as PDF only (already validated above)
                $stored = $request->file($field)->store('vendor_docs', 'public');
                $pathsFromJson[$field] = $stored;
            }
        }

        // (Optional) If msme_registered === 'yes' and you have msme_file from UI:
        if ($request->hasFile('msme_file')) {
            $request->validate([
                'msme_file' => 'file|mimes:pdf|max:20480'
            ]);
            $pathsFromJson['msme_file'] = $request->file('msme_file')->store('vendor_docs', 'public');
        }

        // Extra safety: ensure all provided paths are PDFs
        foreach ($pathsFromJson as $field => $relPath) {
            if (!is_string($relPath) || !str_ends_with(strtolower($relPath), '.pdf')) {
                return response()->json([
                    'status' => false,
                    'errors' => ["$field" => ["$field must be a PDF."]]
                ], 422);
            }
        }

        // Merge file paths into $validated so they’re persisted in columns
        // If your DB columns are named exactly like the field keys, this works directly.
        $validated = array_merge($validated, $pathsFromJson);

        // ---- SAVE ----
        BusinessRegistration::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Business registration data saved successfully!'
        ], 200);
    }
    public function vendor_confiermetion()
    {
        $vendor_id = session('vendor_id');

        return view('web.vendor_confiermetion', [
            'vendor_id' => $vendor_id
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
        return view('web.vendor_likes_project');
    }

     public function likeprojectsData(Request $request)
    {
        $vendorId = session('vendor_id');

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
//             echo"<pre>";
// print_r($query);die;
        // Optional: add filters if needed
        if ($request->project_name) {
            $query->where('projects_details.project_name', 'like', '%' . $request->project_name . '%');
        }

        if ($request->budget_range) {
            $query->where('projects_details.budget_range', 'like', '%' . $request->budget_range . '%');
        }

        return DataTables::of($query)->make(true);
    }

    public function vendor_dashboard(){
        return view('web.vendor_dashboard');
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
//   public function storeTenderDocuments(Request $request)
//     {
//         $vendor_id = session('vendor_id'); // get vendor_id from session

//         $request->validate([
//             'project_id' => 'required|exists:projects_details,id',
//             'emd_receipt' => 'nullable|file|mimes:pdf|max:2048',
//             'company_profile' => 'nullable|file|mimes:pdf|max:2048',
//             'address_proof' => 'nullable|file|mimes:pdf|max:2048',
//             'gst_certificate' => 'nullable|file|mimes:pdf|max:2048',
//             'work_experience' => 'nullable|file|mimes:pdf|max:2048',
//             'financial_capacity' => 'nullable|file|mimes:pdf|max:2048',
//             'declaration' => 'nullable|file|mimes:pdf|max:2048',
//             'boq_file' => 'nullable|file|mimes:xls,xlsx|max:20480'
            
//         ]);

//         $paths = [];

//         // Store each uploaded file
//         foreach ($request->allFiles() as $field => $file) {
//             $paths[$field] = $file->store('tender_docs', 'public');
//         }

//         // Merge and create
//         TenderDocument::create(array_merge([
//             'project_id' => $request->project_id,
//             'vendor_id' => $vendor_id, 
//             'vendor_cost' => $request->vendor_cost,
//         ], $paths));

//         return response()->json(['message' => 'Tender documents uploaded successfully!']);
//     }

    //  public function uploadFiletenderdocuments(Request $request)
    // {
    //     $request->validate([
    //         'field' => 'required|string',
    //         'file'  => 'required|file', // we validate mimes by field below
    //     ]);

    //     $field = $request->string('field');

    //     // Field-specific validation (PDF-only except BOQ)
    //     $rules = [
    //         'emd_receipt'        => 'file|mimes:pdf|max:20480',  // 20 MB
    //         'company_profile'    => 'file|mimes:pdf|max:40960',
    //         'address_proof'      => 'file|mimes:pdf|max:20480',
    //         'gst_certificate'    => 'file|mimes:pdf|max:20480',
    //         'work_experience'    => 'file|mimes:pdf|max:40960',
    //         'financial_capacity' => 'file|mimes:pdf|max:40960',
    //         'declaration'        => 'file|mimes:pdf|max:20480',
    //         'boq_file'           => 'file|mimes:xls,xlsx|max:51200', // 50 MB
    //     ];

    //     $request->validate([
    //         'file' => $rules[$field] ?? 'file|mimes:pdf|max:20480',
    //     ]);

    //     // Decide storage dir per field
    //     $dir = ($field === 'boq_file') ? 'tenders/boq' : 'tenders/pdfs';

    //     // Store on public disk (php artisan storage:link)
    //     $path = $request->file('file')->store($dir, 'public');

    //     return response()->json(['field' => $field, 'path' => $path], 200);
    // }
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

        // Merge and persist (your existing model/columns)
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
}
