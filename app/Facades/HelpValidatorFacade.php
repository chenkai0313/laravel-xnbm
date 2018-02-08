<?php

namespace app\Facades;

use Illuminate\Support\Facades\Facade;


class HelpValidatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'help.validator';
    }
}
