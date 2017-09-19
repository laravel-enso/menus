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
        $this->mergeConfigFrom(__DIR__.'/config/breadcrumbs.php', 'breadcrumbs');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/menumanager');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    private function publishesAll()
    {
        $this->publishes([
            __DIR__.'/config' => config_path(),
        ], 'breadcrumbs-config');

        $this->publishes([
            __DIR__.'/config' => config_path(),
        ], 'enso-config');
    }

    public function register()
    {
        //
    }
}
