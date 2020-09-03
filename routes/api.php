<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes -- FOR ADMINISTRATOR
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

Route::middleware(['auth:api', 'scope:add-currency'])->post('/v1/admin/currencies/add', 'Api\v1\AdminController@add_currency');

Route::middleware(['auth:api', 'scope:view-currencies'])->get('/v1/admin/currencies/list', 'Api\v1\AdminController@get_all_currencies');

Route::middleware(['auth:api', 'scope:get-one-currency'])->get('/v1/admin/currencies/get', 'Api\v1\AdminController@get_one_currency');

Route::middleware(['auth:api', 'scope:view-currencies'])->get('/v1/admin/currencies/search', 'Api\v1\AdminController@search_for_currency');

Route::middleware(['auth:api', 'scope:update-currency'])->post('/v1/admin/currencies/edit', 'Api\v1\AdminController@edit_currency');

Route::middleware(['auth:api', 'scope:add-rate'])->post('/v1/admin/rates/add', 'Api\v1\AdminController@add_rate');

Route::middleware(['auth:api', 'scope:view-rates'])->get('/v1/admin/rates/list', 'Api\v1\AdminController@get_all_rates');

Route::middleware(['auth:api', 'scope:view-rates'])->get('/v1/admin/rates/search', 'Api\v1\AdminController@search_for_rates');

Route::middleware(['auth:api', 'scope:add-bureau'])->post('/v1/admin/bureaus/add', 'Api\v1\AdminController@add_bureau');

Route::middleware(['auth:api', 'scope:view-bureaus'])->get('/v1/admin/bureaus/list', 'Api\v1\AdminController@get_all_bureaus');

Route::middleware(['auth:api', 'scope:view-rates'])->get('/v1/admin/bureaus/search', 'Api\v1\AdminController@search_for_bureaus');

Route::middleware(['auth:api', 'scope:get-one-currency'])->get('/v1/admin/bureaus/get', 'Api\v1\AdminController@get_one_bureau');

Route::middleware(['auth:api', 'scope:update-bureau'])->post('/v1/admin/bureaus/edit', 'Api\v1\AdminController@edit_bureau');



/*
|--------------------------------------------------------------------------
| API Routes -- FOR BUREAU WORKER
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:worker')->post('/v1/bureau/login', 'Api\v1\WorkerController@login');
Route::post('/v1/bureau/login', 'Api\v1\WorkerController@login');

Route::middleware('auth:worker')->get('/v1/bureau/verification', 'Api\v1\WorkerController@verify_passcode');

Route::middleware('auth:worker')->get('/v1/bureau/resend', 'Api\v1\WorkerController@resend_passcode');

Route::middleware('auth:worker')->get('/v1/bureau/logout', 'Api\v1\WorkerController@logout');

Route::middleware(['auth:worker', 'scope:worker_add-customer'])->post('/v1/bureau/customers/add', 'Api\v1\WorkerController@add_customer');

Route::middleware(['auth:worker', 'scope:worker_view-customers'])->get('/v1/bureau/customers/search', 'Api\v1\WorkerController@search_for_customer');

Route::middleware(['auth:worker', 'scope:worker_view-currencies'])->get('/v1/bureau/currencies/list', 'Api\v1\WorkerController@get_all_currencies');

Route::middleware(['auth:worker', 'scope:worker_add-rate'])->post('/v1/bureau/rates/add', 'Api\v1\WorkerController@add_rate');

Route::middleware(['auth:worker', 'scope:worker_view-rates'])->get('/v1/bureau/rates/list', 'Api\v1\WorkerController@get_all_rates');

Route::middleware(['auth:worker', 'scope:worker_view-rates'])->get('/v1/bureau/rates/search', 'Api\v1\WorkerController@search_for_rates');

Route::middleware(['auth:worker', 'scope:worker_add-stock'])->post('/v1/bureau/stocks/add', 'Api\v1\WorkerController@add_currency_stock');

Route::middleware(['auth:worker', 'scope:worker_view-stocks'])->get('/v1/bureau/stocks/list', 'Api\v1\WorkerController@get_all_stocks');

Route::middleware(['auth:worker', 'scope:worker_view-stocks'])->get('/v1/bureau/stocks/search', 'Api\v1\WorkerController@search_for_stocks');

Route::middleware(['auth:worker', 'scope:worker_add-trade'])->post('/v1/bureau/trades/add', 'Api\v1\WorkerController@add_trade');

Route::middleware(['auth:worker', 'scope:worker_view-trades'])->get('/v1/bureau/trades/list', 'Api\v1\WorkerController@get_all_trades');

Route::middleware(['auth:worker', 'scope:worker_view-trades'])->get('/v1/bureau/trades/search', 'Api\v1\WorkerController@search_for_trades');


