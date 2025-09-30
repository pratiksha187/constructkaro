<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyService extends Model
{
    protected $table = 'agency_services';

    protected $fillable = [
        'user_id',
        'work_type_id',
        'work_subtype_id',
        'vendor_type_id',
        'sub_vendor_types'
    ];

    // Cast JSON column automatically
    protected $casts = [
        'sub_vendor_types' => 'array'
    ];
}
