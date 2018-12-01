<?php

namespace Launcher\Larachatter\Facades;

use Illuminate\Support\Facades\Facade;

class Larachatter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'larachatter';
    }
}
