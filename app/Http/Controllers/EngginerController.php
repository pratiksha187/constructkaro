<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetails;
use Illuminate\Support\Facades\DB;
use App\Models\BOQEntry;
use App\Models\Tender;
use Maatwebsite\Excel\Facades\Excel;



class EngginerController extends Controller
{
  
    public function engineer_dashboard()
    {
        // Fetch engineer projects
        $projects = DB::table('projects')
            ->leftJoin('projects_details', 'projects_details.project_id', '=', 'projects.id')
            ->leftJoin('customer_basic_info', 'customer_basic_info.id', '=', 'projects.user_id')
            ->leftJoin('budget_range', 'budget_range.id', '=', 'projects.budget_range')
            ->leftJoin('expected_timeline', 'expected_timeline.id', '=', 'projects.project_duration')
            ->whereNotNull('projects_details.submission_id')
            ->where('projects_details.submission_id', '!=', '')
            ->select([
                'projects.id as project_id',
                'projects_details.project_name',
                'projects_details.project_location',
                'projects_details.project_description',
                'projects_details.tender_status',
                'expected_timeline.timeline',
                'budget_range.budget_range as budget_range_name',
                'customer_basic_info.full_name',
                'customer_basic_info.phone_number',
            ])
            ->orderBy('projects.id', 'desc')
            ->paginate(10);

        // ✅ Simple Stats (you can replace these with real DB counts later)
        $stats = [
            'assigned_projects'   => DB::table('projects')->count(),
            'assigned_delta'      => '',
            'active_tenders'      => DB::table('projects_details')->where('tender_status', 'bidding')->count(),
            'tenders_delta'       => '',
            'pending_boqs'        => DB::table('projects_details')->where('boq_status', '0')->count(),
            'deadlines_this_week' => 0, // can calculate dynamically later
        ];

        // ✅ Task List (optional, dynamic later)
        $tasks = [
            ['title' => 'Prepare BOQ – Retail Fit-Out', 'pct' => 0],
            ['title' => 'Upload EMD receipt – Smart Security', 'pct' => 0],
            ['title' => 'Finalize vendor cost – Tower A', 'pct' => 0],
        ];

        return view('engg.engineer_dashboard', compact('projects', 'stats', 'tasks'));
    }

    public function addmillstone()
    {
        $projects = DB::table('projects_details')->get();

        //  dd($projects);
        return view('engg.add_millstone',compact('projects'));

    }

    public function storemillstone(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'project_id' => 'required',
            'type_of_work.*' => 'required',
            'work_to_be_done.*' => 'required',
            'milestone_title.*' => 'required',
            'milestone_description.*' => 'nullable',
            'timeframe_days.*' => 'required|numeric|min:1',
            'payment_percentage.*' => 'required|numeric|min:0|max:100',
            'verification_point.*' => 'nullable',
        ]);

        // Check that the total payment percentage equals 100%
        // $total = array_sum($request->payment_percentage);
        // if ($total != 100) {
        //     return back()->with('error', 'Total milestone percentage must equal 100%.');
        // }

        // Insert each milestone into the database
        foreach ($request->milestone_title as $index => $title) {
            DB::table('milestones')->insert([
                'project_id' => $request->project_id,
                'type_of_work' => $request->type_of_work[$index],
                'work_to_be_done' => $request->work_to_be_done[$index],
                'milestone_title' => $title,
                'milestone_description' => $request->milestone_description[$index],
                'timeframe_days' => $request->timeframe_days[$index],
                'payment_percentage' => $request->payment_percentage[$index],
                'verification_point' => $request->verification_point[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Redirect back with success message
        return redirect()->route('addmillstone')->with('success', 'Milestones saved successfully!');
    }

    public function updateStatus(Request $request)
    {
        try {
            $updated = DB::table('milestones')
                ->where('id', $request->id)
                ->update(['is_completed' => $request->is_completed]);

            if ($updated) {
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Milestone not found']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getMilestones($projectId)
    {
       
        $projct_id = DB::table('projects_details')->where('project_id',$projectId)->first();
        //  dd($projct_id);
        $milestones = DB::table('milestones')
            ->where('project_id', $projct_id->id)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($milestones);
    }

    public function listMilestones()
    {
        // Get all milestones with project + project_details info
        $milestones = DB::table('milestones')

            ->join('projects_details', 'milestones.project_id', '=', 'projects_details.id')
            ->join('projects', 'projects_details.project_id', '=', 'projects.id')
            ->select(
                'milestones.*',
                'projects.*',
                'projects_details.*',
            
            )
            ->orderBy('milestones.project_id', 'desc')
            ->get();

        // ✅ Group by project_id
        $grouped = $milestones->groupBy('project_id');

        return view('engg.milestones_list', compact('grouped'));
    }


    public function allprojectdata()
    {
        $projects = DB::table('projects')
            ->leftJoin('projects_details', 'projects_details.project_id', '=', 'projects.id')
            ->leftJoin('customer_basic_info', 'customer_basic_info.id', '=', 'projects.user_id')
            ->leftJoin('budget_range', 'budget_range.id', '=', 'projects.budget_range')
            ->leftJoin('expected_timeline', 'expected_timeline.id', '=', 'projects.project_duration')
            ->leftJoin('states', 'states.id', '=', 'customer_basic_info.state')
            ->leftJoin('regions', 'regions.id', '=', 'customer_basic_info.region')
            ->leftJoin('cities', 'cities.id', '=', 'customer_basic_info.city')
            ->leftJoin('work_types', 'work_types.id', '=', 'projects.work_type')
            ->leftJoin('work_subtypes', 'work_subtypes.id', '=', 'projects.work_subtype')
            ->leftJoin('suggested_vendor_types', 'suggested_vendor_types.id', '=', 'projects.vendor_type')
            ->leftJoin('vendor_subcategories', 'vendor_subcategories.id', '=', 'projects.sub_vendor_types')


         
            ->leftJoin('role', 'role.id', '=', 'customer_basic_info.role_id')

            // 🔹 Show only projects that have a submission_id in projects_details
            ->whereNotNull('projects_details.submission_id')
            ->where('projects_details.submission_id', '!=', '') // also avoid empty strings
            ->select([
                // 🟠 PROJECTS TABLE
                'projects.id as project_id',
                'projects.user_id',
                'projects.profile_photo',
                'projects.construction_type_id',
                'projects.project_type_id',
                'projects.site_ready',
                'projects.land_location',
                'projects.survey_number',
                'projects.land_type',
                'projects.sub_categories',
                'projects.land_area',
                'projects.land_unit',
                'projects.arch_drawings',
                'projects.arch_files',
                'projects.struct_drawings',
                'projects.struct_files',
                'projects.has_boq',
                'projects.boq_file',
                'projects.expected_start',
                'projects.project_duration',
                // 'projects.budget_range',
                'budget_range.budget_range as budget_range_name',
                'projects.login_id',
                'projects.site_status',
                'projects.floors',
                'projects.water',
                'projects.electricity',
                'projects.drainage',
                'projects.payment_preference',
                'projects.quality_preference',
                'projects.vendor_preference',
                'projects.best_time',
                'projects.work_type',
                'work_types.work_type as work_types',
                'projects.work_subtype',
                'work_subtypes.work_subtype as work_subtype_name',
                'suggested_vendor_types.vendor_type as suggested_vendor_types',
                'projects.vendor_type',
                'vendor_subcategories.vendor_subcategory as vendor_subcategories',
                'projects.sub_vendor_types',
                'projects.created_at as project_created_at',
                'projects.updated_at as project_updated_at',

                // 🔵 PROJECTS_DETAILS TABLE
                'projects_details.id as detail_id',
                'projects_details.project_name',
                'projects_details.project_location',
                'projects_details.project_description',
                'projects_details.budget_range as detail_budget_range',
                // 'projects_details.expected_timeline',
                'expected_timeline.timeline as timeline',
                'projects_details.file_path',
                'projects_details.confirm',
                'projects_details.project_id as detail_project_id',
                'projects_details.submission_id',
                'projects_details.project_like_by',
                'projects_details.engg_decription',
                'projects_details.call_status',
                'projects_details.call_remarks',
                'projects_details.boq_status',
                'projects_details.tender_status',
                'projects_details.created_at as detail_created_at',
                'projects_details.updated_at as detail_updated_at',

                // 🟢 CUSTOMER_BASIC_INFO TABLE
                'customer_basic_info.id as customer_id',
                'customer_basic_info.full_name',
                'customer_basic_info.phone_number',
                'customer_basic_info.email',
                'customer_basic_info.password',
                'customer_basic_info.gender',
                'customer_basic_info.role_id',
                'role.role as role_name',
                'customer_basic_info.state',
                'customer_basic_info.region',
                'customer_basic_info.city',
                'customer_basic_info.created_at as customer_created_at',
                'customer_basic_info.updated_at as customer_updated_at',

                'states.name as statesname',
                'cities.name as citiesname'  ,
                'regions.name as regionsname'
            ])
            ->orderBy('projects.id', 'desc')
            ->paginate(10);
    // dd($projects);
        return view('engg.allprojectdata', compact('projects'));
    }


    public function NewProjectBoq(){
        $projects = DB::table('projects_details')
                    ->join('projects', 'projects_details.project_id', '=', 'projects.id')
                    ->select(
                        'projects.*',
                        'projects_details.*'
                    )
                    ->get();

        // dd($projects);
        return view('engg.projectboq', compact('projects'));

    }



    public function updateProjectRemarksAndCall(Request $request)
    {
        $request->validate([
            'id' => 'required|integer', // project_id
            'engg_decription' => 'nullable|string|max:1000',
            'call_status' => 'nullable|integer',
            'call_remarks' => 'nullable|string|max:1000',
        ]);

        // ✅ Get the project directly by project_id
        $project = DB::table('projects')->where('id', $request->id)->first();

        if (!$project) {
            return response()->json(['message' => 'Project not found.'], 404);
        }

        // ✅ Update its details in projects_details
        $updated = DB::table('projects_details')
            ->where('project_id', $project->id)
            ->update([
                'engg_decription' => $request->engg_decription,
                'call_status' => $request->call_status,
                'call_remarks' => $request->call_remarks,
                'confirm' => 1,
                'updated_at' => now(),
            ]);

        if ($updated) {
            return response()->json(['message' => 'Engineer details updated successfully.']);
        } else {
            return response()->json(['message' => 'No record found or no changes made.'], 404);
        }
    }

    // public function uploadBOQ(Request $request)
    // {
    //     $request->validate([
    //         'project_id' => 'required|exists:projects_details,id',
    //         'files' => 'required|array',
    //         'files.*' => 'file|mimes:xls,xlsx,csv|max:20480',
    //     ]);

    //     $file = $request->file('files')[0]; 
    //     $filePath = $file->store('boq_files', 'public'); 

    //     $get_project_info_id = DB::table('projects_details')
    //         ->where('id', $request->project_id)
    //         ->first(); 
    //     // dd( $get_project_info_id );
    //     DB::table('projects')
    //         ->where('user_id', $request->project_id)
    //         ->update(['engg_boq_status' => 1])
    //         ->update(['engg_boq_file_uploaded' => $filePath]); 

    //     // DB::table('project_information') 
    //     //     ->where('id', $get_project_info_id->project_id)
    //     //     ->update(['boqFile' => $filePath]); 

    //     return response()->json(['message' => 'BOQ file uploaded successfully!', 'path' => $filePath]);
    // }
    public function uploadBOQ(Request $request)
    {
        // ✅ Step 1: Validate file input
        $request->validate([
            'project_id' => 'required|exists:projects_details,id',
            'files' => 'required|array',
            'files.*' => 'file|mimes:xls,xlsx,csv|max:20480',
        ]);

        // ✅ Step 2: Store the uploaded file in storage/app/public/boq_files
        $file = $request->file('files')[0];
        $filePath = $file->store('boq_files', 'public'); // stored in storage/app/public/boq_files

        // ✅ Step 3: Get the project detail info
        $projectDetail = DB::table('projects_details')
            ->where('id', $request->project_id)
            ->first();

        if (!$projectDetail) {
            return response()->json(['error' => 'Invalid project detail ID.'], 404);
        }

        // ✅ Step 4: Update related 'projects' record
        DB::table('projects')
            ->where('id', $projectDetail->project_id) // use project_id from details
            ->update([
                'engg_boq_status' => 1,
                'engg_boq_file_uploaded' => $filePath,
            ]);

        // ✅ Step 5 (optional): If you also want to update project_information table
        // DB::table('project_information')
        //     ->where('id', $projectDetail->project_id)
        //     ->update(['boqFile' => $filePath]);

        // ✅ Step 6: Return JSON response
        return response()->json([
            'message' => 'BOQ file uploaded successfully!',
            'path' => asset('storage/' . $filePath), // returns usable public URL
        ]);
    }

    public function storetender(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'tender_value' => 'nullable|numeric',
            'product_category' => 'nullable|string',
            'sub_category' => 'nullable|string',
            'contract_type' => 'nullable|string',
            'bid_validity_days' => 'nullable|integer',
            'period_of_work_days' => 'nullable|integer',
            'location' => 'nullable|string',
            'pincode' => 'nullable|string',
            'published_date' => 'nullable|date',
            'bid_opening_date' => 'nullable|date',
            'bid_submission_start' => 'nullable|date',
            'bid_submission_end' => 'nullable|date',
        ]);

        Tender::create($validated);

        DB::table('projects_details')
            ->where('id', $request->project_id)
            ->update(['tender_status' => 1]); 

        return response()->json(['success' => true, 'message' => 'Tender saved successfully.']);
    }

    
    public function get_all_vender_list()
    {
        $allvendor = DB::table('service_provider as sp')
            ->leftJoin('agency_services as asv', 'asv.user_id', '=', 'sp.id')
            ->leftJoin('business_registrations as br', 'br.user_id', '=', 'sp.id')
            ->leftJoin('work_types as wt', 'wt.id', '=', 'br.entity_type')
            ->leftJoin('entity_type as et', 'et.id', '=', 'asv.work_type_id')
            ->leftJoin('account_type as at', 'at.id', '=', 'br.account_type')
            ->leftJoin('experience_years as ey', 'ey.id', '=', 'br.experience_years')
            ->leftJoin('team_size as ts', 'ts.id', '=', 'br.team_size')

            ->leftJoin('vendor_calls as vc', 'vc.vendor_id', '=', 'sp.id')
            ->select(
                'sp.id as vendor_id',
                'sp.name as vendor_name',
                'sp.mobile as vendor_mobile',
                'sp.email as vendor_email',
                'sp.business_name as vendor_business_name',
                'sp.gst_number as vendor_gst_number',
                'sp.state as vendor_state',
                'sp.region as vendor_region',
                'sp.city as vendor_city',
                'sp.vendor_code as vendor_code',

                'asv.id as asv_id',
                'asv.work_type_id as vendor_work_type_id',
                'wt.work_type as vendor_work_type_name',
                'asv.work_subtype_id as vendor_work_subtype_id',
                'asv.vendor_type_id as vendor_type_id',
                'asv.sub_vendor_types as sub_vendor_types',
                'asv.other_service as other_service',

                'br.company_name as br_company_name',
                'br.entity_type as br_entity_type',
                'et.entity_type as et_entity_type',
                'br.registered_address as br_registered_address',
                'br.phone as br_contact_person_name',
                'br.contact_person_designation as br_contact_person_designation',

                'br.gst_number as br_gst_number',
                'br.pan_number as br_pan_number',
                'br.tan_number as br_tan_number',
                'br.esic_number as br_esic_number',
                'br.pf_code as br_pf_code',
                'br.msme_registered as br_msme_registered',
                'br.pan_aadhar_seeded as br_pan_aadhar_seeded',

                'br.bank_name as br_bank_name',
                'br.account_number as br_account_number',
                'br.ifsc_code as br_ifsc_code',
                'br.account_type as br_account_type',
                'at.name as at_bank_account_type',
                'br.approved as br_approved',
                'br.call_status as call_status',
                'br.call_remarks as call_remarks',

                'br.state as br_state',
                'br.region as br_region',
                'br.city as br_city',
                'br.experience_years as br_experience_years',
                'br.team_size as br_team_size',
                'br.service_coverage_area as br_service_coverage_area',
                'br.min_project_value as br_min_project_value',
                'ey.experiance as ey_experiance',
                'ts.team_size as ts_team_size',
                'vc.call_status as call_status',
                'vc.call_remarks as call_remarks',

                DB::raw("
                    CASE
                        WHEN asv.id IS NOT NULL
                        AND br.id IS NOT NULL
                        AND sp.name IS NOT NULL
                        AND sp.mobile IS NOT NULL
                        AND sp.email IS NOT NULL
                        THEN 1
                        ELSE 0
                    END AS is_profile_complete
                ")
            )
            ->orderByDesc('sp.id')
            ->paginate(10);

        // ✅ Decode JSON + Fetch names
        foreach ($allvendor as $vendor) {
            $vendor->vendor_work_subtype_id = json_decode($vendor->vendor_work_subtype_id, true);
            $vendor->vendor_type_id = json_decode($vendor->vendor_type_id, true);
            $vendor->sub_vendor_types = json_decode($vendor->sub_vendor_types, true);

            // ✅ Fetch Work Subtype Names
            if (!empty($vendor->vendor_work_subtype_id)) {
                $vendor->work_subtype_names = DB::table('work_subtypes')
                    ->whereIn('id', $vendor->vendor_work_subtype_id)
                    ->pluck('work_subtype')
                    ->toArray();
            } else {
                $vendor->work_subtype_names = [];
            }

            // ✅ Fetch Vendor Type Names from suggested_vendor_types
            if (!empty($vendor->vendor_work_subtype_id)) {
                $vendor->vendor_type_names = DB::table('suggested_vendor_types')
                    ->whereIn('work_subtype_id', $vendor->vendor_work_subtype_id)
                    ->pluck('vendor_type')
                    ->unique()
                    ->toArray();
            } else {
                $vendor->vendor_type_names = [];
            }
        }
// dd($allvendor);
        return view('engg.get_all_vender_list', compact('allvendor'));
    }


    public function updateVendorCallStatus(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|integer',
            'call_status' => 'required|string|max:255',
            'call_remarks' => 'nullable|string',
        ]);

        // Check if vendor already has a call entry
        $existing = DB::table('vendor_calls')->where('vendor_id', $request->vendor_id)->first();

        if ($existing) {
            // ✅ Update existing
            DB::table('vendor_calls')
                ->where('vendor_id', $request->vendor_id)
                ->update([
                    'call_status' => $request->call_status,
                    'call_remarks' => $request->call_remarks,
                    'updated_at' => now(),
                ]);
        } else {
            // ✅ Or insert new
            DB::table('vendor_calls')->insert([
                'vendor_id' => $request->vendor_id,
                'call_status' => $request->call_status,
                'call_remarks' => $request->call_remarks,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function billverification(){
           $bills = DB::table('projects')
                    ->leftJoin('projects_details', 'projects_details.project_id', '=', 'projects.id')
                    ->leftJoin('customer_basic_info', 'customer_basic_info.id', '=', 'projects.user_id')
                    ->leftJoin('monthly_bills', 'monthly_bills.project_id', '=', 'projects_details.project_id')

        // 🔹 Show only projects that have a submission_id in projects_details
                    ->whereNotNull('projects_details.submission_id')
                    ->where('projects_details.submission_id', '!=', '') // also avoid empty strings
                    ->select([
                        // 🟠 PROJECTS TABLE
                        'projects.id as project_id',
                        'projects.user_id',
                    

                        // 🔵 PROJECTS_DETAILS TABLE
                        'projects_details.id as detail_id',
                        'projects_details.project_name',
                        'projects_details.project_location',
                        'projects_details.project_description',
                        'projects_details.budget_range as detail_budget_range',
                        'projects_details.expected_timeline',
                    
                        // 🟢 CUSTOMER_BASIC_INFO TABLE
                        'customer_basic_info.id as customer_id',
                        'customer_basic_info.full_name',
                        'customer_basic_info.phone_number',
                        'customer_basic_info.email',
                        'customer_basic_info.password',
                        'customer_basic_info.gender',
                    
                        'monthly_bills.*'
                    ])
                    ->orderBy('projects.id', 'desc')
                    ->paginate(10);
                    // dd($projects);

    return view('engg.billverificationlist', compact('bills'));

    }

    public function showBill($id)
    {
        $bill = DB::table('monthly_bills as b')
            ->join('projects_details as d', 'd.project_id', '=', 'b.project_id')
            // ->join('customer_basic_info as c', 'c.id', '=', 'd.project_id')
            ->select('b.*', 'd.project_name')
            ->where('b.id', $id)
            ->first();
    // dd($bill);
        return view('engg.bill_modal', compact('bill'));
    }

    public function updateBillStatus(Request $request, $id)
    {
        // ✅ Validate input
        $request->validate([
            'status' => 'required|in:Approved,Revised,Rejected',
            'engineer_remarks' => 'nullable|string|max:1000',
        ]);

        // ✅ Update bill record
        DB::table('monthly_bills')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'engineer_remarks' => $request->engineer_remarks,
                'updated_at' => now(),
            ]);

        // ✅ Redirect back with success message
        return redirect()
            ->route('billverification')
            ->with('success', 'Bill status updated successfully!');
    }


    
}
