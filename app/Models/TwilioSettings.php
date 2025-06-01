<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwilioSettings extends Model
{
    protected $fillable = [
        'user_id',
        'twilio_number',
    ];

    /**
     * Get the user that owns the twilio settings.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 