<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system')->as('system.')
    ->namespace('LaravelEnso\MenuManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('menus')->as('menus.')
            ->group(function () {
                Route::get('initTable', 'MenuTableController@init')
                    ->name('initTable');
                Route::get('tableData', 'MenuTableController@data')
                    ->name('tableData');
                Route::get('exportExcel', 'MenuTableController@excel')
                    ->name('exportExcel');
            });

        Route::resource('menus', 'MenuController')
            ->except('show', 'index');
    });
