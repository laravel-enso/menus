<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/system/menus')
    ->as('system.menus.')
    ->namespace('LaravelEnso\Menus\app\Http\Controllers')
    ->group(function () {
        Route::get('create', 'Create')->name('create');
        Route::post('', 'Store')->name('store');
        Route::get('{menu}/edit', 'Edit')->name('edit');
        Route::patch('{menu}', 'Update')->name('update');
        Route::delete('{menu}', 'Destroy')->name('destroy');
        Route::put('organize', 'Organize')->name('organize');

        Route::get('tableData', 'Table@data')->name('tableData');
        Route::get('initTable', 'Table@init')->name('initTable');
        Route::get('exportExcel', 'Table@excel')->name('exportExcel');
    });
