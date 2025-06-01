<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case SENT = 'sent';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

    public static function values(): array
    {
        return array_map(fn (QuoteStatus $type) => $type->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::SENT => 'Sent',
            self::PENDING => 'Pending',
            self::REJECTED => 'Rejected',
        };
    }

    public static function toDropdown(): array
    {
        return array_map(fn (QuoteStatus $type) => [
            'id' => $type->value,
            'label' => $type->label(),
        ], self::cases());
    }
} 