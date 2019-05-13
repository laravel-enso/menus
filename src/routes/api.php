<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system')->as('system.')
    ->namespace('LaravelEnso\MenuManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('menus')->as('menus.')
            ->group(function () {
                Route::get('create', 'Create')->name('create');
                Route::post('store', 'Store')->name('store');
                Route::get('{menu}/edit', 'Edit')->name('edit');
                Route::patch('{menu}', 'Update')->name('update');
                Route::delete('{menu}', 'Destroy')->name('destroy');

                Route::get('tableData', 'Table@data')->name('tableData');
                Route::get('initTable', 'Table@init')->name('initTable');
                Route::get('exportExcel', 'Table@excel')->name('exportExcel');
            });
    });
