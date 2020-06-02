<?php

namespace common\services\gender;

interface GenderServiceInterface 
{
    const MALE = 1;
    const FEMALE = 0;
    const UNKNOWN = 2;

    public function get(string $name);
}