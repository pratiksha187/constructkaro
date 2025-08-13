<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'vendor_cost',
        'project_id',
        'emd_receipt',
        'company_profile',
        'address_proof',
        'gst_certificate',
        'work_experience',
        'financial_capacity',
        'declaration',
        'boq_file',
    ];
}

