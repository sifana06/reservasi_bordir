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

    Route::get('profile', 'DashboardController@profile')->name('profile');
    Route::post('profile', 'DashboardController@profileUpdate')->name('profile.update');

    Route::group(['middleware' => 'auth.isAdmin'], function(){
        Route::get('settings', 'SettingController@index')->name('setting');

        Route::get('users', 'UsersController@index')->name('user.index');
        Route::get('users/create', 'UsersController@create')->name('user.create');
        Route::post('users', 'UsersController@store')->name('user.store');
        Route::get('user-datatable', 'UsersController@getData')->name('user.getdata');
        Route::get('user/edit/{id}', 'UsersController@edit')->name('user.edit');
        Route::put('user/update/{id}', 'UsersController@update')->name('user.update');
        Route::get('user/{id}/delete', 'UsersController@destroy')->name('user.delete');

        Route::get('rekening', 'RekeningController@index')->name('rekening.index');
        Route::get('rekening/create', 'RekeningController@create')->name('rekening.create');
        Route::post('rekening', 'RekeningController@store')->name('rekening.store');

    });
    
    Route::group(['middleware' => 'role:isAdmin,isPemilik'], function(){
        Route::get('transaksi', 'TransaksiController@index')->name('transaksi.index');
        Route::get('transaksi/create', 'TransaksiControler@create')->name('transaksi.create');
        Route::post('create', 'TransaksiController@store')->name('transaksi.store');
    });

    Route::group(['middleware' => 'role:isPemilik'], function(){
        Route::get('order', 'OrderController@index')->name('order.index');
        Route::get('order/create', 'OrderController@create')->name('order.create');
        Route::post('create', 'OrderController@store')->name('order.store');

        Route::get('produk', 'ProdukController@index')->name('produk.index');
        Route::get('produk/create', 'ProdukController@create')->name('produk.create');
        Route::post('create', 'ProdukController@store')->name('produk.store');
    });

    Route::group(['middleware' => 'role:isPelanggan'], function(){
        Route::get('home', 'HomeController@index')->name('home');
        
        Route::group(['prefix' => 'order'], function(){
            Route::get('/', 'OrderController@order')->name('po.index');
        });

        Route::group(['prefix' => 'history'], function(){
            Route::get('/', 'HistoryController@index')->name('history.index');
        });
    });
});