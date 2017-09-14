<?php

namespace App\Models\Enums;

class CommonStatus
{
    const ACTIVE = 'ACTIVE';
    const INACTIVE = 'INACTIVE';

    public static function getAll(): array
    {
        return [static::ACTIVE, static::INACTIVE];
    }
}