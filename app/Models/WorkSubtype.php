<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSubtype extends Model
{
    protected $fillable = ['work_type_id', 'name'];

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
}
