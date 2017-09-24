<?php

namespace LaravelEnso\MenuManager;

use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        //
    }
}
