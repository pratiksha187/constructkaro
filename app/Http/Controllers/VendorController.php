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

        $path = $request->file('file')->store('vendor_docs', 'public');

        return response()->json(['path' => $path], 200);
    }
 

    public function business_store(Request $request)
    {
        // 1) Validate
        $validated = $request->validate([
            'experience_years'              => 'required',
            'team_size'                     => 'required',
            'service_coverage_area'         => 'required', // may be array from multiselect
            'min_project_value'             => 'required|numeric',
            'company_name'                  => 'required|string',
            'entity_type'                   => 'required', // select -> int/string
            'registered_address'            => 'required|string',
            'contact_person_designation'    => 'required|string',
            'gst_number'                    => 'required|string',
            'pan_number'                    => 'required|string',
            'tan_number'                    => 'nullable|string',
            'esic_number'                   => 'nullable|string',
            'pf_code'                       => 'nullable|string',
            'msme_registered'               => ['required', Rule::in(['yes','no'])],
            'bank_name'                     => 'required|string',
            'account_number'                => 'required|string',
            'ifsc_code'                     => 'required|string',
            'account_type'                  => 'required', // select
            'agreed_declaration'            => 'nullable', // checkbox
            'aadhar_section'                => 'nullable',
            'cin_section'                   => 'nullable',
            'llpin_no'                      => 'nullable|string',

            // optional direct uploads (single file each)
            'cancelled_cheque_file'               => 'nullable|file|mimes:pdf|max:20480',
            'pan_card_file'                       => 'nullable|file|mimes:pdf|max:20480',
            'aadhaar_card_file'                   => 'nullable|file|mimes:pdf|max:20480',
            'certificate_of_incorporation_file'   => 'nullable|file|mimes:pdf|max:20480',
            'itr_file'                            => 'nullable|file|mimes:pdf|max:40960',
            'turnover_certificate_file'           => 'nullable|file|mimes:pdf|max:20480',
            'work_completion_certificates_file'   => 'nullable|file|mimes:pdf|max:40960',
            'pf_esic_documents_file'              => 'nullable|file|mimes:pdf|max:20480',
            'company_profile_file'                => 'nullable|file|mimes:pdf|max:40960',
            'portfolio_file'                      => 'nullable|file|mimes:pdf|max:40960',
            'past_work_photos_file'               => 'nullable|file|mimes:pdf|max:40960',
            'license_certificate_file'            => 'nullable|file|mimes:pdf|max:20480',
            'uploadadharpanFile'                  => 'nullable|file|mimes:pdf|max:20480',

            // paths coming from your sequential uploader (JSON object)
            'uploaded_paths'                      => 'nullable|string',
        ]);

        // 2) Vendor + default flags
        $validated['user_id']  = session('vendor_id');
        $validated['approved'] = 0;

        // 3) Collect paths from JSON map (sequential uploader)
        $pathsFromJson = json_decode($request->input('uploaded_paths', '{}'), true) ?: [];

        // 4) Also support direct uploads in this request
        $fileFields = [
            'cancelled_cheque_file','pan_card_file','aadhaar_card_file',
            'certificate_of_incorporation_file','itr_file','turnover_certificate_file',
            'work_completion_certificates_file','pf_esic_documents_file',
            'company_profile_file','portfolio_file','past_work_photos_file',
            'license_certificate_file','uploadadharpanFile'
        ];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $pathsFromJson[$field] = $request->file($field)->store('vendor_docs', 'public'); // "public/vendor_docs/..."
            }
        }
        // Optional MSME file
        if ($request->hasFile('msme_file')) {
            $request->validate(['msme_file' => 'file|mimes:pdf|max:20480']);
            $pathsFromJson['msme_file'] = $request->file('msme_file')->store('vendor_docs', 'public');
        }

        // 5) Normalize data to scalars (avoid array-to-string)
        // service_coverage_area can be multiselect -> array
        $serviceCoverage = $request->input('service_coverage_area', []);
        if (is_array($serviceCoverage)) {
            // store as comma-separated; OR use json_encode($serviceCoverage)
            $serviceCoverage = implode(',', array_filter($serviceCoverage, fn($v) => $v !== null && $v !== ''));
        }

        // checkbox to boolean (1/0)
        $agreed = $request->boolean('agreed_declaration') ? 1 : 0;

        // Ensure all file path values are strings (flatten if any array sneaks in)
        foreach ($pathsFromJson as $k => $v) {
            if (is_array($v)) {
                $pathsFromJson[$k] = implode(',', $v); // or pick first: $v[0] ?? null
            }
        }

        // 6) Build insert payload (only scalar values)
        $payload = [
            'experience_years'                => (string)$validated['experience_years'],
            'team_size'                       => (string)$validated['team_size'],
            'service_coverage_area'           => $serviceCoverage,
            'min_project_value'               => $validated['min_project_value'],
            'company_name'                    => $validated['company_name'],
            'entity_type'                     => (string)$validated['entity_type'],
            'registered_address'              => $validated['registered_address'],
            'contact_person_designation'      => $validated['contact_person_designation'],
            'gst_number'                      => $validated['gst_number'],
            'pan_number'                      => $validated['pan_number'],
            'tan_number'                      => $validated['tan_number'] ?? null,
            'esic_number'                     => $validated['esic_number'] ?? null,
            'pf_code'                         => $validated['pf_code'] ?? null,
            'msme_registered'                 => $validated['msme_registered'],   // 'yes'|'no' stored as text; or map to 1/0
            'bank_name'                       => $validated['bank_name'],
            'account_number'                  => $validated['account_number'],
            'ifsc_code'                       => $validated['ifsc_code'],
            'account_type'                    => (string)$validated['account_type'],
            'agreed_declaration'              => $agreed,
            'llpin_no'                        => $validated['llpin_no'] ?? null,
            'user_id'                         => $validated['user_id'],
            'approved'                        => 0,
            'created_at'                      => now(),
            'updated_at'                      => now(),
        ];

        // merge stored file paths (strings) into payload
        $payload = array_merge($payload, $pathsFromJson);

        // 7) Insert (Query Builder; no model)
        DB::table('business_registrations')->insert($payload);

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
