<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\IndustryType;
use App\Enums\QuoteStatus;
use App\Enums\QuoteSource;

class Quote extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'location',
        'industry_type',
        'ai_response',
        'edited_response',
        'sent_at',
        'from_number',
        'to_number',
        'sms_id',
        'status',
        'source',
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
            'sent_at' => 'datetime',
            'status' => QuoteStatus::class,
            'source' => QuoteSource::class,
        ];
    }

    /**
     * Get the user that owns the quote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 