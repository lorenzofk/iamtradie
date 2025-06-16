<?php

declare(strict_types=1);

namespace App\Enums;

enum QuoteStatus: string
{
    case SENT = 'sent';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case FAILED = 'failed';

    public static function values(): array
    {
        return array_map(fn (QuoteStatus $type) => $type->value, self::cases());
    }

    public static function toDropdown(): array
    {
        return array_map(fn (QuoteStatus $type) => [
            'id' => $type->value,
            'label' => $type->label(),
        ], self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::SENT => 'Sent',
            self::PENDING => 'Pending',
            self::REJECTED => 'Rejected',
            self::FAILED => 'Failed',
        };
    }
}
