<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\IndustryType;
use App\Enums\ResponseTone;

class UserSettings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id', 
        'industry_type',
        'phone', 
        'callout_fee',
        'hourly_rate',
        'response_tone',
        'preferred_cta',
        'auto_send_sms',
        'auto_send_email',
        'quotes_used',
        'quotes_limit',
    ];

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
            'auto_send_email' => 'boolean',
            'callout_fee' => 'decimal:2',
            'hourly_rate' => 'decimal:2',
            'quotes_used' => 'integer',
            'quotes_limit' => 'integer',
        ];
    }

    /**
     * Get the user that owns the settings.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
