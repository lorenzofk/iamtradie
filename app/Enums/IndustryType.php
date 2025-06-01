<?php

namespace App\Enums;

enum IndustryType: string
{
    case ELECTRICAL = 'electrical';
    case PLUMBING = 'plumbing';
    case TILING = 'tiling';
    case CARPENTRY = 'carpentry';
    case PAINTING = 'painting';
    case GENERAL = 'general';

    /**
     * Get the values of the industry types.
     */
    public static function values(): array
    {
        return array_map(fn (IndustryType $type) => $type->value, self::cases());
    }

    /**
     * Get the label for the industry type.
     */
    public function label(): string
    {
        return match ($this) {
            self::ELECTRICAL => 'Electrical',
            self::PLUMBING => 'Plumbing',
            self::TILING => 'Tiling',
            self::CARPENTRY => 'Carpentry',
            self::PAINTING => 'Painting',
            self::GENERAL => 'General',
        };
    }

    /**
     * Get the industry types as a dropdown array.
     */
    public static function toDropdown(): array
    {
        return array_map(fn (IndustryType $type) => [
            'id' => $type->value,
            'label' => $type->label(),
        ], self::cases());
    }
}