<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\IndustryType;
use App\Enums\ResponseTone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'industry_type',
        'business_name',
        'business_location',
        'phone_number',
        'mobile_number',
        'agent_sms_number',
        'callout_fee',
        'hourly_rate',
        'response_tone',
        'auto_send_sms',
        'call_forward_enabled',
        'auto_send_sms_after_voicemail',
        'quotes_used',
        'quotes_limit',
        'call_ring_duration',
        'voicemail_message',
    ];

    /**
     * Get the user that owns the settings.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'industry_type' => IndustryType::class,
            'response_tone' => ResponseTone::class,
            'auto_send_sms' => 'boolean',
            'call_forward_enabled' => 'boolean',
            'auto_send_sms_after_voicemail' => 'boolean',
            'callout_fee' => 'float',
            'hourly_rate' => 'float',
            'quotes_used' => 'integer',
            'quotes_limit' => 'integer',
            'call_ring_duration' => 'integer',
        ];
    }
}
