<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AfterRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'Called' => [
                'required', 
                'string',
            ],
            'CallSid' => [
                'required', 
                'string',
            ],
            'From' => [
                'nullable',
                'string',
            ],
            'Caller' => [
                'nullable',
                'string',
            ],
            'CallerCountry' => [
                'nullable',
                'string',
            ],
            'FromCountry' => [
                'nullable',
                'string',
            ],
            'Direction' => [
                'nullable',
                'string',
            ],
            'CallStatus' => [
                'nullable',
                'string',
            ],
            'RecordingSid' => [
                'nullable',
                'string',
            ],
            'RecordingUrl' => [
                'nullable',
                'string',
            ],
            'RecordingDuration' => [
                'nullable',
                'integer',
            ],
            'Digits' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Get the Called number (Twilio agent number).
     */
    public function getCalledNumber(): string
    {
        return $this->input('Called');
    }

    /**
     * Get the Call SID.
     */
    public function getCallSid(): string
    {
        return $this->input('CallSid');
    }

    /**
     * Get the From number (or Caller as fallback).
     */
    public function getFromNumber(): ?string
    {
        return $this->input('From') ?? $this->input('Caller');
    }

    /**
     * Get the caller country (or FromCountry as fallback).
     */
    public function getCallerCountry(): ?string
    {
        return $this->input('CallerCountry') ?? $this->input('FromCountry');
    }

    /**
     * Get the call direction.
     */
    public function getDirection(): string
    {
        return $this->input('Direction', 'inbound');
    }

    /**
     * Get the call status.
     */
    public function getCallStatus(): string
    {
        return $this->input('CallStatus', 'completed');
    }

    /**
     * Get the recording SID.
     */
    public function getRecordingSid(): ?string
    {
        return $this->input('RecordingSid');
    }

    /**
     * Get the recording URL.
     */
    public function getRecordingUrl(): ?string
    {
        return $this->input('RecordingUrl');
    }

    /**
     * Get the recording duration.
     */
    public function getRecordingDuration(): ?int
    {
        $duration = $this->input('RecordingDuration');
        return $duration ? (int) $duration : null;
    }

    /**
     * Get the digits.
     */
    public function getDigits(): ?string
    {
        return $this->input('Digits');
    }
} 