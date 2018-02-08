<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class AdminFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AdminService';
    }
}