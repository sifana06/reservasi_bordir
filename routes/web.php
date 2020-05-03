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
    });
    
    Route::group(['middleware' => 'role:isAdmin,isPemilik'], function(){
        Route::get('transaksi', 'TransaksiController@index')->name('transaksi.index');
        Route::get('transaksi/create', 'TransaksiControler@create')->name('transaksi.create');
        Route::post('create', 'TransaksiController@store')->name('transaksi.store');
        
        Route::get('rekening', 'RekeningController@index')->name('rekening.index');
        Route::get('rekening/create', 'RekeningController@create')->name('rekening.create');
        Route::post('rekening', 'RekeningController@store')->name('rekening.store');
        Route::get('data-rekening', 'RekeningController@getData')->name('rekening.getdata');
        Route::get('rekening/edit/{id}', 'RekeningController@edit')->name('rekening.edit');
        Route::put('rekening/update/{id}', 'RekeningController@update')->name('rekening.update');
        Route::get('rekening/{id}/delete', 'RekeningController@destroy')->name('rekening.delete');

        Route::get('toko', 'StoreController@index')->name('toko.index');
        Route::get('toko/create', 'StoreController@create')->name('toko.create');
        Route::post('toko', 'StoreController@store')->name('toko.store');
        Route::get('data-toko', 'StoreController@getData')->name('toko.getdata');
        Route::get('toko/edit/{id}', 'StoreController@edit')->name('toko.edit');
        Route::put('toko/update/{id}', 'StoreController@update')->name('toko.update');
        Route::get('toko/{id}/delete','StoreController@destroy')->name('toko.delete');

    });

    Route::group(['middleware' => 'role:isPemilik'], function(){
        Route::get('order', 'OrderController@index')->name('order.index');
        Route::get('order/create', 'OrderController@create')->name('order.create');
        Route::post('create', 'OrderController@store')->name('order.store');

        Route::get('product', 'ProductController@index')->name('product.index');
        Route::get('product/create', 'ProductController@create')->name('product.create');
        Route::post('create', 'ProductController@store')->name('product.store');
        Route::get('data-product', 'ProductController@getData')->name('product.getdata');
        Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');
        Route::put('product/update/{id}', 'ProductController@update')->name('product.update');
        Route::get('product/{id}/delete', 'ProductController@destroy')->name('product.delete');
    });

    Route::group(['prefix' => 'p', 'middleware' => 'role:isPelanggan'], function(){
        Route::get('home', 'HomeController@index')->name('home');
        
        Route::group(['prefix' => 'order'], function(){
            Route::get('/', 'OrderController@order')->name('po.index');
        });

        Route::group(['prefix' => 'history'], function(){
            Route::get('/', 'HistoryController@index')->name('history.index');
        });

        Route::group(['prefix' => 'store'], function(){
            Route::get('/', 'StoreController@indexStore')->name('store.index');
            Route::get('create', 'StoreController@createStore')->name('store.create');
            Route::post('/', 'StoreController@storeStore')->name('store.store');
            Route::get('data-store', 'StoreController@getDataStore')->name('store.getdata');
            Route::get('edit/{id}', 'StoreController@editStore')->name('store.edit');
            Route::put('update/{id}', 'StoreController@updateStore')->name('store.update');
            Route::get('{id}/delete','StoreController@delete')->name('store.delete');
        });
    });
});