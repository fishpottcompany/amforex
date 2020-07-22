<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/administrator', function (Request $request) {
    return $request->user();
});

Route::post('/v1/admin/register', 'Api\v1\AdminController@register');

Route::post('/v1/admin/login', 'Api\v1\AdminController@login');

Route::middleware('auth:api')->get('/v1/admin/verification', 'Api\v1\AdminController@verify_passcode');

Route::middleware('auth:api')->get('/v1/admin/resend', 'Api\v1\AdminController@resend_passcode');

Route::middleware('auth:api')->get('/v1/admin/logout', 'Api\v1\AdminController@logout');

Route::middleware('auth:api')->post('/v1/admin/currencies/add', 'Api\v1\AdminController@add_currency');

Route::middleware('auth:api')->get('/v1/admin/currencies/list', 'Api\v1\AdminController@get_all_currencies');

Route::middleware('auth:api')->get('/v1/admin/currencies/get', 'Api\v1\AdminController@get_one_currency');

Route::middleware('auth:api')->post('/v1/admin/currencies/edit', 'Api\v1\AdminController@edit_currency');

//Route::get('/v1/admin/verification', 'Api\v1\AdminController@verify_passcode');

