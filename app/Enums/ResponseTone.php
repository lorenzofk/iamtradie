<?php

namespace App\Enums;

enum ResponseTone: string
{
    case CASUAL = 'casual';
    case POLITE = 'polite';
    case PROFESSIONAL = 'professional';

    public function getDescription(): string
    {
        return match($this) {
            self::CASUAL => 'Friendly, conversational tone with Australian slang',
            self::POLITE => 'Respectful and courteous, professional but warm',
            self::PROFESSIONAL => 'Formal business language with technical terminology',
        };
    }

    public static function getOptions(): array
    {
        return [
            ['value' => self::CASUAL->value, 'label' => 'Casual', 'description' => self::CASUAL->getDescription()],
            ['value' => self::POLITE->value, 'label' => 'Polite', 'description' => self::POLITE->getDescription()],
            ['value' => self::PROFESSIONAL->value, 'label' => 'Professional', 'description' => self::PROFESSIONAL->getDescription()],
        ];
    }
}