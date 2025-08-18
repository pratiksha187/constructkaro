<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{

 protected $table = 'projects';

    protected $fillable = [
        'full_name', 'phone_number', 'email', 'password', 'role_id',
        'construction_type_id', 'project_type_id', 'site_ready',
        'land_location', 'survey_number', 'land_type', 'land_area', 'land_unit',
        'arch_drawings', 'struct_drawings', 'has_boq', 'boq_file',
        'expected_start', 'project_duration', 'budget_range','sub_categories'
    ];

   
}
