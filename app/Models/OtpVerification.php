<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'channel','destination','code_hash','expires_at','verified_at','attempts','last_sent_at','session_key',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'last_sent_at' => 'datetime',
    ];

    public function isExpired(): bool {
        return now()->greaterThan($this->expires_at);
    }

    public function isVerified(): bool {
        return !is_null($this->verified_at);
    }
}
