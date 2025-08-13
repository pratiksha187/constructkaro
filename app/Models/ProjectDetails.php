<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectDetails extends Model
{
    use HasFactory;
    protected $table = 'projects_details';
    protected $fillable = [
        'project_name',
        'confirm',
        'project_id',
        'submission_id',
        'project_type',
        'project_location',
        'project_description',
        'budget_range',
        'expected_timeline',
        'file_path',
        'engg_decription',
    ];
}