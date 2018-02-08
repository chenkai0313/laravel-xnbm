<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class SysTimeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SysTimeService';
    }
}