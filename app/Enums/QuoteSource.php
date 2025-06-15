<?php

declare(strict_types=1);

namespace App\Enums;

enum QuoteSource: string
{
    case SMS = 'sms';
    case EMAIL = 'email';

    public static function values(): array
    {
        return array_map(fn (QuoteSource $type) => $type->value, self::cases());
    }

    public static function toDropdown(): array
    {
        return array_map(fn (QuoteSource $type) => [
            'id' => $type->value,
            'label' => $type->label(),
        ], self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::SMS => 'SMS',
            self::EMAIL => 'Email',
        };
    }
}
