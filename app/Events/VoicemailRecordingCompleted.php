<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoicemailRecordingCompleted
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly string $callSid,
        public readonly string $fromNumber,
        public readonly string $callerCountry,
        public readonly string $direction,
        public readonly string $callStatus,
        public readonly ?string $recordingSid,
        public readonly ?string $recordingUrl,
        public readonly ?int $recordingDuration,
        public readonly ?string $digits,
        public readonly User $user
    ) {}
} 