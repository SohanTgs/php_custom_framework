<?php

namespace App\Facade;

use App\Facade\Facade;

class DB extends Facade{
    
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}