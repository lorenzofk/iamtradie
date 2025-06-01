<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwilioSettings extends Model
{
    protected $fillable = [
        'user_id',
        'twilio_number',
        'twilio_auth_token',
        'twilio_account_sid',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 