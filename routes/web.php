<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    // Application Additional Overwrites here
    Route::get('/customer',['uses' => 'App\Http\Controllers\Admin\VoyagerCustomerController@browse',  'as' => 'voyager.customer.browse']);
    Route::post('/customer/create',['uses' => 'App\Http\Controllers\Admin\VoyagerCustomerController@create',  'as' => 'voyager.customer.create']);
    Route::post('/address/create',['uses' => 'App\Http\Controllers\Admin\VoyagerAddressController@create',  'as' => 'voyager.address.create']);
    Route::get('/customer/store',['uses' => 'App\Http\Controllers\Admin\VoyagerCustomerController@store',  'as' => 'voyager.customer.store']);
    Route::get('/customer/{id}',['uses' => 'App\Http\Controllers\Admin\VoyagerCustomerController@show',  'as' => 'voyager.customer.show']);
    Route::get('/address/{id}/store',['uses' => 'App\Http\Controllers\Admin\VoyagerAddressController@store',  'as' => 'voyager.address.store']);
    Route::get('/customer/{id}/edit',['uses' => 'App\Http\Controllers\Admin\VoyagerCustomerController@edit',  'as' => 'voyager.customer.edit']);
    Route::get('/address/{id}/edit',['uses' => 'App\Http\Controllers\Admin\VoyagerAddressController@edit',  'as' => 'voyager.address.edit']);
    Route::put('/customer/{id}/update',['uses' => 'App\Http\Controllers\Admin\VoyagerCustomerController@update',  'as' => 'voyager.customer.update']);
    Route::put('/address/{id}/update',['uses' => 'App\Http\Controllers\Admin\VoyagerAddressController@update',  'as' => 'voyager.address.update']);
    Route::delete('/customer/{id}/destroy',['uses' => 'App\Http\Controllers\Admin\VoyagerCustomerController@destroy',  'as' => 'voyager.customer.destroy']);
    Route::delete('/address/{id}/destroy',['uses' => 'App\Http\Controllers\Admin\VoyagerAddressController@destroy',  'as' => 'voyager.address.destroy']);
});
