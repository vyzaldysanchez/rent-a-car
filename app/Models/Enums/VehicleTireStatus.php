<?php

namespace App\Models\Enums;

class VehicleTireStatus
{
    const NEW = 'new';
    const USED = 'used';
    const WASTED = 'wasted';

    public static function getAll(): array
    {
        return [
            static::NEW,
            static::USED,
            static::WASTED
        ];
    }
}