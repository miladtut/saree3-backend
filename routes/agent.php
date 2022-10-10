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

        Route::group(['prefix' => 'broker', 'as' => 'broker.'], function () {
            Route::get('get-stores-data/{store}', 'BrokerController@get_store_data')->name('get-stores-data');
            Route::get('store-filter/{id}', 'BrokerController@store_filter')->name('storefilter');
            Route::get('get-account-data/{broker}', 'BrokerController@get_account_data')->name('storefilter');
            Route::get('get-brokers', 'BrokerController@get_brokers')->name('get-brokers');
            Route::get('get-addons', 'BrokerController@get_addons')->name('get_addons');



            Route::get('add', 'BrokerController@index')->name('add');
            Route::post('store', 'BrokerController@store')->name('store');
            Route::get('list', 'BrokerController@list')->name('list');
            Route::post('search', 'BrokerController@search')->name('search');

        });

        Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
            Route::get('get-stores-data/{store}', 'VendorController@get_store_data')->name('get-stores-data');
            Route::get('store-filter/{id}', 'VendorController@store_filter')->name('storefilter');
            Route::get('get-account-data/{store}', 'VendorController@get_account_data')->name('storefilter');
            Route::get('get-stores', 'VendorController@get_stores')->name('get-stores');
            Route::get('get-addons', 'VendorController@get_addons')->name('get_addons');
            Route::group(['middleware' => ['module:store']], function () {
                Route::get('update-application/{id}/{status}', 'VendorController@update_application')->name('application');
                Route::get('add', 'VendorController@index')->name('add');
                Route::post('store', 'VendorController@store')->name('store');
                Route::get('edit/{id}', 'VendorController@edit')->name('edit');
                Route::post('update/{store}', 'VendorController@update')->name('update');
                Route::post('discount/{store}', 'VendorController@discountSetup')->name('discount');
                Route::post('update-settings/{store}', 'VendorController@updateStoreSettings')->name('update-settings');
                Route::delete('delete/{store}', 'VendorController@destroy')->name('delete');
                Route::delete('clear-discount/{store}', 'VendorController@cleardiscount')->name('clear-discount');
                // Route::get('view/{store}', 'VendorController@view')->name('view_tab');
                Route::get('view/{store}/{tab?}/{sub_tab?}', 'VendorController@view')->name('view');
                Route::get('list', 'VendorController@list')->name('list');
                Route::post('search', 'VendorController@search')->name('search');
                Route::get('status/{store}/{status}', 'VendorController@status')->name('status');
                Route::get('featured/{store}/{status}', 'VendorController@featured')->name('featured');
                Route::get('toggle-settings-status/{store}/{status}/{menu}', 'VendorController@store_status')->name('toggle-settings');
                Route::post('status-filter', 'VendorController@status_filter')->name('status-filter');

                //Import and export
                Route::get('bulk-import', 'VendorController@bulk_import_index')->name('bulk-import');
                Route::post('bulk-import', 'VendorController@bulk_import_data');
                Route::get('bulk-export', 'VendorController@bulk_export_index')->name('bulk-export-index');
                Route::post('bulk-export', 'VendorController@bulk_export_data')->name('bulk-export');
                //Store shcedule
                Route::post('add-schedule', 'VendorController@add_schedule')->name('add-schedule');
                Route::get('remove-schedule/{store_schedule}', 'VendorController@remove_schedule')->name('remove-schedule');
            });

            Route::group(['middleware' => ['module:withdraw_list']], function () {
                Route::post('withdraw-status/{id}', 'VendorController@withdrawStatus')->name('withdraw_status');
                Route::get('withdraw_list', 'VendorController@withdraw')->name('withdraw_list');
                Route::get('withdraw-view/{withdraw_id}/{seller_id}', 'VendorController@withdraw_view')->name('withdraw_view');
            });

        });

        Route::group(['prefix' => 'delivery-man', 'as' => 'delivery-man.'], function () {
            Route::get('get-account-data/{deliveryman}', 'DeliveryManController@get_account_data')->name('storefilter');
            Route::group(['middleware' => ['module:deliveryman']], function () {
                Route::get('add', 'DeliveryManController@index')->name('add');
                Route::post('store', 'DeliveryManController@store')->name('store');
                Route::get('list', 'DeliveryManController@list')->name('list');
                Route::get('preview/{id}/{tab?}', 'DeliveryManController@preview')->name('preview');
                Route::get('status/{id}/{status}', 'DeliveryManController@status')->name('status');
                Route::get('earning/{id}/{status}', 'DeliveryManController@earning')->name('earning');
                Route::get('update-application/{id}/{status}', 'DeliveryManController@update_application')->name('application');
                Route::get('edit/{id}', 'DeliveryManController@edit')->name('edit');
                Route::post('update/{id}', 'DeliveryManController@update')->name('update');
                Route::delete('delete/{id}', 'DeliveryManController@delete')->name('delete');
                Route::post('search', 'DeliveryManController@search')->name('search');
                Route::get('get-deliverymen', 'DeliveryManController@get_deliverymen')->name('get-deliverymen');

                Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
                    Route::get('list', 'DeliveryManController@reviews_list')->name('list');
                    Route::get('status/{id}/{status}', 'DeliveryManController@reviews_status')->name('status');
                });
            });
        });
    });





});

