<?php

namespace App\Models\Enums;

class EmployeeWorkSchedule
{
    const MORNING = 'Morning';
    const AFTERNOON = 'Afternoon';
    const NIGHT = 'Night';

    public static function getAll(): array
    {
        return [
            static::MORNING,
            static::AFTERNOON,
            static::NIGHT
        ];
    }
}