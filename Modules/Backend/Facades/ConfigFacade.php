<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class ConfigFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ConfigService';
    }
}