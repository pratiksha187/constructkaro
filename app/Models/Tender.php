<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $table ='tenders';
    protected $fillable = [
        'project_id',
        'tender_value',
        'product_category',
        'sub_category',
        'contract_type',
        'bid_validity_days',
        'period_of_work_days',
        'location',
        'pincode',
        'published_date',
        'bid_opening_date',
        'bid_submission_start',
        'bid_submission_end',
];

}
