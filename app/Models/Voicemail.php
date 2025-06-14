<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voicemail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'call_sid',
        'from_number',
        'caller_country',
        'direction',
        'call_status',
        'recording_sid',
        'recording_url',
        'recording_duration',
        'digits',
        'transcription_text',
        'transcription_processed',
        'ai_response',
        'sms_sent',
        'sms_sent_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'transcription_processed' => 'boolean',
            'sms_sent' => 'boolean',
            'sms_sent_at' => 'datetime',
            'recording_duration' => 'integer',
        ];
    }

    /**
     * Get the user that owns the voicemail.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the voicemail has a recording.
     */
    public function hasRecording(): bool
    {
        return !empty($this->recording_url) && !empty($this->recording_sid);
    }

    /**
     * Check if the voicemail has been transcribed.
     */
    public function hasTranscription(): bool
    {
        return !empty($this->transcription_text);
    }

    /**
     * Check if an AI response was generated and SMS sent.
     */
    public function wasProcessed(): bool
    {
        return $this->transcription_processed && $this->sms_sent;
    }
}
