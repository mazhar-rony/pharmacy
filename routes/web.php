<?php

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function() {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});
