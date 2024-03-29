<?php

namespace Coderello\VirtualFields\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Coderello\VirtualFields\Commands\VirtualFieldMakeCommand;

class VirtualFieldsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap shared data service.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            VirtualFieldMakeCommand::class,
        ]);
    }
}
