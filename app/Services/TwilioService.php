<?php

namespace App\Services;

use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(config('services.twilio.sid'), config('services.twilio.token'));
    }

    /**
     * Send an SMS message.
     */
    public function send(string $to, string $from, string $message): void
    {
        Log::withContext(['to' => $to, 'from' => $from, 'message' => $message]);

        try {
            $this->client->messages->create($to, ['from' => $from, 'body' => $message]);
        } catch (Exception $e) {
            Log::error('Failed to send SMS', ['error' => $e->getMessage()]);
        }
        
        Log::info('SMS sent successfully');
    }
}
