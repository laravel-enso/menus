<?php

Route::get('create', 'Create')->name('create');
Route::post('', 'Store')->name('store');
Route::get('{menu}/edit', 'Edit')->name('edit');
Route::patch('{menu}', 'Update')->name('update');
Route::delete('{menu}', 'Destroy')->name('destroy');
Route::put('organize', 'Organize')->name('organize');

Route::get('initTable', 'InitTable')->name('initTable');
Route::get('tableData', 'TableData')->name('tableData');
Route::get('exportExcel', 'ExportExcel')->name('exportExcel');
