<?php

namespace LaravelEnso\MenuManager;

use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadDependencies();
        $this->publishesAll();
    }

    private function loadDependencies()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/menumanager');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    private function publishesAll()
    {
        $this->publishes([
            __DIR__.'/resources/assets/js/components' => resource_path('assets/js/vendor/laravel-enso/components'),
        ], 'menus-component');

        $this->publishes([
            __DIR__.'/resources/assets/js/components' => resource_path('assets/js/vendor/laravel-enso/components'),
        ], 'enso-update');
    }

    public function register()
    {
        //
    }
}
