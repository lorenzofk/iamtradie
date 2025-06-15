<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],
            'customer_phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\+]?[1-9][\d]{0,15}$/',
            ],
            'project_description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'estimated_hours' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'materials_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'additional_notes' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }
}
