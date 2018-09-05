<?php

namespace LaravelEnso\MenuManager;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadDependencies();

        $this->publishesAll();
    }

    private function loadDependencies()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    private function publishesAll()
    {
        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'menus-assets');

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'enso-assets');
    }

    public function register()
    {
        //
    }
}
