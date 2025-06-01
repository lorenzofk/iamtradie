<?php

namespace App\Enums;

enum ResponseTone: string
{
    case CASUAL = 'casual';
    case POLITE = 'polite';
    case PROFESSIONAL = 'professional';

    /**
     * Get the values of the response tones.
     */
    public static function values(): array
    {
        return array_map(fn (ResponseTone $tone) => $tone->value, self::cases());
    }

    /**
     * Get the label for the transaction type.
     */
    public function label(): string
    {
        return match ($this) {
            self::CASUAL => 'Casual',
            self::POLITE => 'Polite',
            self::PROFESSIONAL => 'Professional',
        };
    }

    /**
     * Get the response tones as a dropdown array.
     */
    public static function toDropdown(): array
    {
        return array_map(fn (ResponseTone $tone) => [
            'id' => $tone->value,
            'label' => $tone->label(),
        ], self::cases());
    }
}