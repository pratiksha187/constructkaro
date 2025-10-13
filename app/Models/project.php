<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{

 protected $table = 'projects';

    protected $fillable = [
        
        'construction_type_id', 'project_type_id', 'site_ready','user_id',
        'land_location', 'survey_number', 'land_type', 'land_area', 'land_unit',
        'arch_drawings', 'struct_drawings', 'has_boq', 'boq_file',
        'expected_start', 'project_duration', 'budget_range','sub_categories','struct_files','arch_files','floors','water','electricity',
        'drainage','payment_preference','quality_preference','vendor_preference','best_time','work_subtype','sub_vendor_types','vendor_type','work_type'
    ];

   
}
