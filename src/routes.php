<?php
Route::group([
    'prefix' => 'search',
    'namespace' => 'FileSearch\Controllers',
    'as' => 'filesearch.'
], function(){
    Route::get('/', 'FileSearchController@index')->name('index');
});