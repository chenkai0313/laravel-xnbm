<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class ApplyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ApplyService';
    }
}