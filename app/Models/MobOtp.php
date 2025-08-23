<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobOtp extends Model
{
    protected $table ='mobotps';
    protected $fillable = ['phone', 'otp', 'expires_at', 'verified'];
}
