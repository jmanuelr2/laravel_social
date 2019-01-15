<?php
Route::view('/', 'welcome')->name('home');
Route::get('statuses', 'StatusesController@index')->name('statuses.index');
Route::post('statuses', 'StatusesController@store')->name('statuses.store')->middleware('auth');
Route::view('/prueba', 'prueba')->name('prueba');
Route::auth();




