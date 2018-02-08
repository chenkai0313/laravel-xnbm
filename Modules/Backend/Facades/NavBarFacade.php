<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class NavBarFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  'NavBarService';
    }
}