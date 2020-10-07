<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Menus\Http\Controllers\Create;
use LaravelEnso\Menus\Http\Controllers\Destroy;
use LaravelEnso\Menus\Http\Controllers\Edit;
use LaravelEnso\Menus\Http\Controllers\ExportExcel;
use LaravelEnso\Menus\Http\Controllers\InitTable;
use LaravelEnso\Menus\Http\Controllers\Organize;
use LaravelEnso\Menus\Http\Controllers\Store;
use LaravelEnso\Menus\Http\Controllers\TableData;
use LaravelEnso\Menus\Http\Controllers\Update;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/system/menus')
    ->as('system.menus.')
    ->group(function () {
        Route::get('create', Create::class)->name('create');
        Route::post('', Store::class)->name('store');
        Route::get('{menu}/edit', Edit::class)->name('edit');
        Route::patch('{menu}', Update::class)->name('update');
        Route::delete('{menu}', Destroy::class)->name('destroy');
        Route::put('organize', Organize::class)->name('organize');

        Route::get('initTable', InitTable::class)->name('initTable');
        Route::get('tableData', TableData::class)->name('tableData');
        Route::get('exportExcel', ExportExcel::class)->name('exportExcel');
    });
