<?php

namespace Faker\Provider;

class StringProvider extends Base
{
    public function randomString($length = 0): string
    {
        return strtoupper(substr(md5(mt_rand()), 0, $length));
    }
}