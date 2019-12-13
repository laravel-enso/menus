<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system/menus')
    ->as('system.menus.')
    ->namespace('LaravelEnso\Menus\app\Http\Controllers')
    ->group(function () {
        require 'app/menus.php';
    });
