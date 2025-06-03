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

    /**
     * Provision a Twilio number for the user (stub for MVP).
     */
    public function provisionTwilioNumber($user): void
    {
        // In a real implementation, you would purchase a number from Twilio here.
        // For MVP, just assign a static or fake number.
        $number = '+61412345678'; // Replace with real logic or a pool of numbers
        
        $user->settings()->updateOrCreate([], ['agent_sms_number' => $number]);
    }
}
