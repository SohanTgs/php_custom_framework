<?php

namespace Ovolab\BackOffice\Facade;

use Ovolab\BackOffice\Facade\Facade;

class Session extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'session';
    }
}