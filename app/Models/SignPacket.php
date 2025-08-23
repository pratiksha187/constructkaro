<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignPacket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ext_id',
        'status',
        'doc_name',
        'signer_email',
        'signer_phone',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
