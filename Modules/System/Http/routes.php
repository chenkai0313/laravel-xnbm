<?php
/**
Route::group(['middleware' => 'web', 'prefix' => 'system', 'namespace' => 'Modules\System\Http\Controllers'], function()
{
    Route::get('/', 'SystemController@index');
});*/

$api = app('Dingo\Api\Routing\Router');
