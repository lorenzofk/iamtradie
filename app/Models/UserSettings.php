
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSettings extends Model
{
    protected $fillable = [
        'user_id', 'industry_type', 'phone', 'callout_fee', 'hourly_rate',
        'response_tone', 'preferred_cta', 'auto_send_sms', 'auto_send_email',
        'twilio_number', 'quotes_used', 'quotes_limit'
    ];

    protected $casts = [
        'auto_send_sms' => 'boolean',
        'auto_send_email' => 'boolean',
        'callout_fee' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'quotes_used' => 'integer',
        'quotes_limit' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
