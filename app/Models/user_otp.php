<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class user_otp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'verification_token',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function isExpired()
    {
        return $this->expires_at < Carbon :: now();
    }

    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }
}
