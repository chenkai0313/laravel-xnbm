<?php
/**
 * Created by PhpStorm.
 * User: pc16
 * Date: 2017/8/1
 * Time: 14:05
 */
namespace Modules\System\Facades;

use Illuminate\Support\Facades\Facade;

class RegionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'RegionService';
    }
}