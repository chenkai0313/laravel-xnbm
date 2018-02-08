<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class AdminLogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AdminLogService';
    }
}
