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

    public function allprojectdata()
    {
        $projects = DB::table('projects_details')
            ->join('projects', 'projects_details.project_id', '=', 'projects.id')
            ->select('projects.*', 'projects_details.*')
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

    // public function get_all_vender_list(){
    //     $allvendor = DB::table('service_provider')
    //                 ->orderBy('service_provider.id', 'desc')
    //                     ->paginate(10); 
    //         dd($allvendor);
    //     return view('engg.get_all_vender_list',compact('allvendor'));

    // }
    // public function get_all_vender_list()
    // {
    //     $allvendor = DB::table('service_provider as sp')
    //         ->leftJoin('agency_services as asv', 'asv.user_id', '=', 'sp.id')
    //         ->leftJoin('business_registrations as br', 'br.user_id', '=', 'sp.id')
    //         ->select(
    //             'sp.name as vender_name',
    //             'sp.mobile as vender_mobile',
    //             'sp.email as vender_email',
    //             'sp.business_name as vender_business_name',
    //             'sp.gst_number as vender_gst_number',
    //             'sp.state as vender_state',
    //             'sp.region as vender_region',
    //             'sp.city as vender_city',
    //             'sp.vendor_code as vendor_code',
    //             'asv.work_type_id as vendor_work_subtype_id',
    //             'asv.work_subtype_id as vendor_work_subtype_id',
    //             'asv.vendor_type_id as vendor_type_id',
    //             'asv.sub_vendor_types as sub_vendor_types',
    //             'br.experience_years as experience_years',
    //             'br.team_size as team_size',
    //             'br.service_coverage_area as service_coverage_area',
    //             'br.min_project_value as min_project_value',
    //             'br.state as br_state',
    //             'br.region as br_region',
    //             'br.city as br_city',
    //             'br.company_name as br_company_name',
    //             'br.entity_type as br_entity_type',
    //             'br.registered_address as br_registered_address',



    //             'asv.*',     
            
    //             'br.*'
    //         )
    //         ->orderBy('sp.id', 'desc')
    //         ->paginate(10);
    // dd($allvendor);
    //     return view('engg.get_all_vender_list', compact('allvendor'));
    // }

public function get_all_vender_list()
{
    $allvendor = DB::table('service_provider as sp')
        ->leftJoin('agency_services as asv', 'asv.user_id', '=', 'sp.id')
        ->leftJoin('business_registrations as br', 'br.user_id', '=', 'sp.id')
        ->select(
            // ========================== SERVICE PROVIDER (sp) ==========================
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

            // ========================== AGENCY SERVICES (asv) ==========================
            'asv.work_type_id as vendor_work_type_id',
            'asv.work_subtype_id as vendor_work_subtype_id',
            'asv.vendor_type_id as vendor_type_id',
            'asv.sub_vendor_types as sub_vendor_types',

            // ========================== BUSINESS REGISTRATIONS (br) ==========================
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
            'br.cancelled_cheque_file as br_cancelled_cheque_file',

            'br.pan_card_file as br_pan_card_file',
            'br.aadhaar_card_file as br_aadhaar_card_file',
            'br.certificate_of_incorporation_file as br_certificate_of_incorporation_file',
            'br.itr_file as br_itr_file',
            'br.turnover_certificate_file as br_turnover_certificate_file',
            'br.work_completion_certificates_file as br_work_completion_certificates_file',
            'br.work_completion_certificates_file1 as br_work_completion_certificates_file1',
            'br.work_completion_certificates_file2 as br_work_completion_certificates_file2',
            'br.work_completion_certificates_file3 as br_work_completion_certificates_file3',

            'br.pf_documents_file as br_pf_documents_file',
            'br.epic_documents_file as br_epic_documents_file',
            'br.company_profile_file as br_company_profile_file',
            'br.portfolio_file as br_portfolio_file',
            'br.past_work_photos as br_past_work_photos',
            'br.license_certificate_file as br_license_certificate_file',

            'br.agreed_declaration as br_agreed_declaration',
            'br.cin_section as br_cin_section',
            'br.aadhar_section as br_aadhar_section',
            'br.uploadadharpanFile as br_uploadadharpanFile',
            'br.llpin_no as br_llpin_no',
            'br.client_name as br_client_name',
            'br.organization as br_organization',
            'br.phone as br_phone',
            'br.email as br_email',
            'br.year_of_completion as br_year_of_completion',
            'br.esic_documents_file as br_esic_documents_file',
            'br.created_at as br_created_at',
            'br.updated_at as br_updated_at',
            'br.user_id as br_user_id',
            'br.approved as br_approved',

            'br.state as br_state',
            'br.region as br_region',
            'br.city as br_city',
            'br.experience_years as br_experience_years',
            'br.team_size as br_team_size',
            'br.service_coverage_area as br_service_coverage_area',
            'br.min_project_value as br_min_project_value'
        )
        ->orderByDesc('sp.id')
        ->paginate(10);

    // Debugging (optional)
    // dd($allvendor);

    return view('engg.get_all_vender_list', compact('allvendor'));
}

}
