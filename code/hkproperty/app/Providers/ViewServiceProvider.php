<?php

namespace App\Providers;

use App\Models\CustomerStatus;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*', 'App\Http\ViewComposers\PreloadOptionsComposer');
    }
}
