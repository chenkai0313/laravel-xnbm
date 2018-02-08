<?php

namespace app\Facades;

use Illuminate\Support\Facades\Facade;


class ThirdValidatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'third.thirdValidator';
    }
}
