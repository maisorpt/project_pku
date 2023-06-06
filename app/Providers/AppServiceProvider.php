<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use setlocale;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        setlocale(LC_ALL, 'IND');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {   
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
    }
}
