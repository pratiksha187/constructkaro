<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EmailOtp extends Model
{
    protected $table = 'email_otps';

    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * Check if the OTP is still valid (not expired).
     */
    public function isValid()
    {
        return $this->expires_at && $this->expires_at->isFuture();
    }
}

