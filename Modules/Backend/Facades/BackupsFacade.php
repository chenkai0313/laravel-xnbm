<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class BackupsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'BackupsService';
    }
}