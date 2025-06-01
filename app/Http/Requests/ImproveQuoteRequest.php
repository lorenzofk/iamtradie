<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImproveQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'original_response' => [
                'required',
                'string',
                'max:2000'
            ],
            'improvements' => [
                'required',
                'string',
                'max:1000'
            ]
        ];
    }
}
