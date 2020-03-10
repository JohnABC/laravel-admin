<?php

namespace LaravelAdmin\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelAdmin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laraveladmin';
    }
}
