<?php

namespace App\Models\Enums;

class UserRole
{
    const ADMIN = 'admin';
    const EMPLOYEE = 'employee';

    public static function getAll(): array
    {
        return [
            static::ADMIN,
            static::EMPLOYEE
        ];
    }
}