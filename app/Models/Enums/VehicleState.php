<?php

namespace App\Models\Enums;


class VehicleState
{
    const AVAILABLE = 'AVAILABLE';
    const RENTED = 'RENTED';
    const DAMAGED = 'DAMAGED';
    const REPAIRED = 'REPAIRED';

    static function getStates(): array
    {
        return [
            static::AVAILABLE,
            static::RENTED,
            static::DAMAGED,
            static::REPAIRED
        ];
    }
}