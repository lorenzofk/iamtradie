<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            username: config('services.twilio.sid'),
            password: config('services.twilio.token')
        );
    }

    /**
     * Send an SMS message.
     */
    public function send(string $to, string $from, string $message): void
    {
        Log::withContext([
            'to' => $to,
            'from' => $from,
            'message' => mb_substr($message, 0, 100).'...',
        ]);

        try {
            $this->client->messages->create($to, ['from' => $from, 'body' => $message]);
        } catch (Exception $e) {
            Log::error('[TWILIO SERVICE] - Failed to send SMS.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
