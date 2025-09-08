<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ServiceProvider extends Authenticatable
{
    protected $table = 'service_provider';

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'business_name',
        'gst_number',
        'location',
        'vendor_code',
        'password',
    ];

    protected $hidden = ['password'];
}

