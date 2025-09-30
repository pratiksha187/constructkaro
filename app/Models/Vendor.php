<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    
    protected $fillable = ['work_subtype_id', 'type', 'sub_categories'];

    public function workSubtype()
    {
        return $this->belongsTo(WorkSubtype::class);
    }
}
