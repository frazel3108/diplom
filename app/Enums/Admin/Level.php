<?php

namespace App\Enums\Admin;

enum Level: int
{
    case NO_ACCESS = 0;
    case FULL_ACCESS = 1;
    case PARTIAL_ACCESS = 2;

    public static function fromKey(string $key): ?static
    {
        return match ($key) {
            'NO_ACCESS' => static::NO_ACCESS,
            'FULL_ACCESS' => static::FULL_ACCESS,
            'PARTIAL_ACCESS' => static::PARTIAL_ACCESS,
            default => null,
        };
    }

}
