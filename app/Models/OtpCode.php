<?php
// app/Models/OtpCode.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OtpCode extends Model
{
    protected $fillable = [
        'type','recipient','code','expires_at','consumed_at','session_id','attempts'
    ];
    protected $casts = [
        'expires_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    public function isExpired(): bool    { return now()->greaterThan($this->expires_at); }
    public function isConsumed(): bool   { return !is_null($this->consumed_at); }
}
