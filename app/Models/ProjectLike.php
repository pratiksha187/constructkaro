<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectLike extends Model
{
    protected $table ='project_likes';
    protected $fillable = [
        'project_id',
        'vendor_id',
        'ip_address',
    ];
}
