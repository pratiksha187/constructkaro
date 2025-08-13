<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyService extends Model
{
    protected $table='agency_services';
    protected $fillable = ['user_id','agency_type', 'services','other_service'];

}
