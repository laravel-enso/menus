<?php

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\MenuManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('system')->as('system.')
            ->group(function () {
                Route::prefix('menus')->as('menus.')
                    ->group(function () {
                        Route::get('initTable', 'MenuController@initTable')
                            ->name('initTable');
                        Route::get('getTableData', 'MenuController@getTableData')
                            ->name('getTableData');
                        Route::get('exportExcel', 'MenuController@exportExcel')
                            ->name('exportExcel');

                        Route::get('reorder', 'MenuReorderController@reorder')
                            ->name('reorder');
                        Route::patch('setOrder', 'MenuReorderController@setOrder')
                            ->name('setOrder');
                    });

                Route::resource('menus', 'MenuController', ['except' => ['show']]);
            });
    });
