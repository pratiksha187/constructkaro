<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessRegistration extends Model
{
    use HasFactory;
    protected $table = 'business_registrations';
  
    protected $fillable = [
        'experience_years', 'team_size', 'service_coverage_area', 'min_project_value',
        'llpin_no', 'uploadadharpanFile', 'company_name', 'entity_type', 'registered_address',
        'contact_person_designation', 'gst_number', 'pan_number', 'tan_number',
        'esic_number', 'pf_code', 'msme_registered', 'pan_aadhar_seeded',
        'bank_name', 'account_number', 'ifsc_code', 'account_type',
        'cancelled_cheque_file', 'pan_card_file', 'aadhaar_card_file',
        'certificate_of_incorporation_file', 'itr_file', 'turnover_certificate_file',
        'work_completion_certificates_file', 'pf_documents_file','epic_documents_file',
        'company_profile_file', 'portfolio_file', 'past_work_photos_file',
        'license_certificate_file', 'agreed_declaration', 'user_id', 'approved'
    ];

}
