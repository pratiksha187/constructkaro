<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BOQEntry extends Model
{
    protected $table='boq_entries';
    protected $fillable = ['project_id', 'item'];
}
