<?php

namespace App\Models\Enums;


class RentState
{
    const ON_GOING = 'on_going';
    const ENDED = 'ended';
    const IN_REVISION = 'in_revision';
    const NOT_STARTED = 'not_started';

    public static function getAll(): array
    {
        return [
            static::NOT_STARTED,
            static::ON_GOING,
            static::IN_REVISION,
            static::ENDED
        ];
    }
}