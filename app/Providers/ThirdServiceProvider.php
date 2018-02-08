<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ThirdServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->addFacade();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerThirdValidator();
    }

    public function registerThirdValidator()
    {
        $this->app->bind('third.thirdValidator','Libraries\Service\ThirdValidatorService');
    }

    public function addFacade()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('thirdValidator',  \App\Facades\ThirdValidatorFacade::class);
    }

}
