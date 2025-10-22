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
    public function engineer_dashboard(){
        return view('engg.engineer_dashboard');
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
        $projects = DB::table('projects_details')
            ->join('projects', 'projects_details.project_id', '=', 'projects.id')
            ->select('projects.*', 'projects_details.*')
            ->orderBy('projects.id', 'desc')
            ->paginate(10); 
  
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


        return view('engg.projectboq', compact('projects'));

    }

   public function updateRemarks(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'engg_decription' => 'nullable|string|max:1000'
        ]);

        $project = ProjectDetails::findOrFail($request->id);
        $project->engg_decription = $request->engg_decription;

        $project->save(); 

        return response()->json(['message' => 'Remarks updated']);
    }


    public function updateCallResponse(Request $request){
        $request->validate([
            'id' => 'required',
            'call_status' => 'required',
            'call_remarks' => 'nullable|string',
        ]);

        $CallResponse = ProjectDetails::findOrFail($request->id);
        $CallResponse->call_status = $request->call_status;
        $CallResponse->call_remarks = $request->call_remarks;
        $CallResponse->save(); 
        return response()->json(['message' => 'CallResponse updated']);

    }
    public function uploadBOQ(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects_details,id',
            'files' => 'required|array',
            'files.*' => 'file|mimes:xls,xlsx,csv|max:20480',
        ]);

        $file = $request->file('files')[0]; 
        $filePath = $file->store('boq_files', 'public'); 

        $get_project_info_id = DB::table('projects_details')
            ->where('id', $request->project_id)
            ->first(); 

        DB::table('projects_details')
            ->where('id', $request->project_id)
            ->update(['boq_status' => 1]); 

        DB::table('project_information') 
            ->where('id', $get_project_info_id->project_id)
            ->update(['boqFile' => $filePath]); 

        return response()->json(['message' => 'BOQ file uploaded successfully!', 'path' => $filePath]);
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
            ->leftJoin('work_types as wt', 'wt.id', '=', 'asv.work_type_id')
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

                'asv.work_type_id as vendor_work_type_id',
                'wt.work_type as vendor_work_type_name',
                'asv.work_subtype_id as vendor_work_subtype_id',
                'asv.vendor_type_id as vendor_type_id',
                'asv.sub_vendor_types as sub_vendor_types',

                'br.company_name as br_company_name',
                'br.entity_type as br_entity_type',
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

                // ✅ Add computed profile completeness check
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



}
