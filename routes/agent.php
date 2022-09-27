<?php

use Illuminate\Support\Facades\Route;

Route::group( ['namespace' => 'Agent', 'as' => 'agent.'], function () {
    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
    /*authentication*/

    Route::group(['middleware' => ['agent']], function () {
        Route ::get ( '/' , 'DashboardController@dashboard' ) -> name ( 'dashboard' );
        Route ::get ( '/get-store-data' , 'DashboardController@store_data' ) -> name ( 'get-store-data' );
        Route ::get ( '/reviews' , 'ReviewController@index' ) -> name ( 'reviews' ) -> middleware ( 'module:reviews' );
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['module:bank_info']], function () {
        Route::get('view', 'ProfileController@view')->name('view');
        // Route::get('update', 'ProfileController@edit')->name('update');
        Route::post('update', 'ProfileController@update')->name('update');
        Route::post('settings-password', 'ProfileController@settings_password_update')->name('settings-password');
        Route::get('bank-view', 'ProfileController@bank_view')->name('bankView');
        Route::get('bank-edit', 'ProfileController@bank_edit')->name('bankInfo');
        Route::post('bank-update', 'ProfileController@bank_update')->name('bank_update');
    });

    Route::group(['prefix' => 'wallet', 'as' => 'wallet.', 'middleware' => ['module:wallet']], function () {
        Route::get('/', 'WalletController@index')->name('index');
        Route::post('request', 'WalletController@w_request')->name('withdraw-request');
        Route::delete('close/{id}', 'WalletController@close_request')->name('close-request');
    });

});

