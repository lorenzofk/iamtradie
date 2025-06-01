
<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSettings;
use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    private Client $client;
    private string $defaultFromNumber;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->defaultFromNumber = config('services.twilio.from');
    }

    public function sendSms(string $to, string $message, ?string $from = null): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $from ?? $this->defaultFromNumber,
                'body' => $message
            ]);

            Log::info('SMS sent successfully', [
                'to' => $to,
                'from' => $from ?? $this->defaultFromNumber
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to send SMS', [
                'to' => $to,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    public function sendQuoteSms(User $user, array $quoteData): bool
    {
        $settings = $user->getOrCreateSettings();
        
        if (!$settings->auto_send_sms || !$settings->twilio_number) {
            return false;
        }

        $message = $this->formatQuoteMessage($user, $quoteData, $settings);
        
        return $this->sendSms(
            $quoteData['customer_phone'],
            $message,
            $settings->twilio_number
        );
    }

    public function sendCustomMessage(User $user, string $to, string $message): bool
    {
        $settings = $user->getOrCreateSettings();
        
        if (!$settings->twilio_number) {
            throw new Exception('Twilio number not configured for user');
        }

        return $this->sendSms($to, $message, $settings->twilio_number);
    }

    public function validatePhoneNumber(string $phoneNumber): bool
    {
        try {
            $lookup = $this->client->lookups->v1->phoneNumbers($phoneNumber)->fetch();
            return !empty($lookup->phoneNumber);
        } catch (Exception $e) {
            Log::warning('Phone number validation failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function getAccountBalance(): ?float
    {
        try {
            $account = $this->client->api->v2010->accounts(config('services.twilio.sid'))->fetch();
            return (float) $account->balance;
        } catch (Exception $e) {
            Log::error('Failed to fetch Twilio account balance', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function listPhoneNumbers(): array
    {
        try {
            $phoneNumbers = $this->client->incomingPhoneNumbers->read();
            
            return array_map(function ($number) {
                return [
                    'sid' => $number->sid,
                    'phone_number' => $number->phoneNumber,
                    'friendly_name' => $number->friendlyName,
                    'capabilities' => $number->capabilities
                ];
            }, $phoneNumbers);
        } catch (Exception $e) {
            Log::error('Failed to fetch Twilio phone numbers', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    private function formatQuoteMessage(User $user, array $quoteData, UserSettings $settings): string
    {
        $tone = $this->getMessageTone($settings->response_tone);
        
        $message = sprintf(
            "%s\n\nHi %s,\n\n%s for your %s project.\n\nCallout Fee: $%.2f\nHourly Rate: $%.2f/hr\n\n%s\n\n%s",
            $tone['greeting'],
            $quoteData['customer_name'] ?? 'there',
            $tone['quote_intro'],
            $settings->industry_type,
            $settings->callout_fee,
            $settings->hourly_rate,
            $quoteData['quote_details'] ?? 'Please contact us for more details.',
            $settings->preferred_cta ?: $tone['default_cta']
        );

        return $message;
    }

    private function getMessageTone(string $tone): array
    {
        return match ($tone) {
            'casual' => [
                'greeting' => 'Hey!',
                'quote_intro' => 'Thanks for reaching out! Here\'s a quote',
                'default_cta' => 'Hit me back if you have any questions!'
            ],
            'polite' => [
                'greeting' => 'Hello',
                'quote_intro' => 'Thank you for your inquiry. I\'m pleased to provide a quote',
                'default_cta' => 'Please don\'t hesitate to contact me if you have any questions.'
            ],
            'professional' => [
                'greeting' => 'Good day',
                'quote_intro' => 'Thank you for considering our services. Please find our formal quote',
                'default_cta' => 'We look forward to the opportunity to work with you.'
            ],
            default => [
                'greeting' => 'Hello',
                'quote_intro' => 'Thank you for your inquiry. Here\'s your quote',
                'default_cta' => 'Please contact us if you have any questions.'
            ]
        };
    }
}
