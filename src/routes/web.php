<?php

Route::group([
    'namespace' => 'LaravelEnso\MenuManager\app\Http\Controllers',
    'middleware' => ['web', 'auth', 'core']
], function () {
	Route::group(['prefix' => 'system', 'as' => 'system.'], function () {
        Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
            Route::get('reorder', 'MenuController@reorder')->name('reorder');
            Route::patch('setOrder', 'MenuController@setOrder')->name('setOrder');
            Route::patch('setAllocation', 'MenuController@setAllocation')->name('setAllocation');
            Route::get('initTable', 'MenuController@initTable')->name('initTable');
            Route::get('getTableData', 'MenuController@getTableData')->name('getTableData');
        });

        Route::resource('menus', 'MenuController');
	});
});