<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IncomingTextMessageReceived
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly string $messageBody,
        public readonly string $leadNumber,
        public readonly string $twilioNumber,
        public readonly string $smsId,
        public readonly User $user,
        public readonly bool $isChatting
    ) {}
}
