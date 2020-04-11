<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('/', 'DashboardController@index')->name('dashboard.index');
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function(){
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('home', 'DashboardController@dashboard')->name('dashboard');

    Route::group(['middleware' => 'auth.isAdmin'], function(){
        Route::get('users', 'UsersController@index')->name('user.index');
        Route::get('users/create', 'UsersController@create')->name('user.create');
        Route::post('users', 'UsersController@store')->name('user.store');
        Route::get('user-datatable', 'UsersController@getData')->name('user.getdata');
        Route::get('user/edit/{id}', 'UsersController@edit')->name('user.edit');
        Route::put('user/update/{id}', 'UsersController@update')->name('user.update');
        Route::get('user/{id}/delete', 'UsersController@destroy')->name('user.delete');
    });
});