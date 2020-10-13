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

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES  ---------- WEB  ---------- WEB  ---------- WEB
|--------------------------------------------------------------------------
*/

// LOGIN
Route::get('/admin/', function () {
    return view('/admin/login');
});

Route::get('/admin/login', function () {
    return view('/admin/login');
});

//PASSCODE VERIFICATION
Route::get('/admin/verification', function () {
    return view('admin/otp');
});

Route::get('/admin/hold', function () {
    return view('admin/otp');
});

// CURRENCIES

Route::get('/admin/currencies/list', function () {
    return view('admin/currencies/list');
});

Route::get('/admin/currencies/add', function () {
    return view('admin/currencies/add');
});

Route::get('/admin/currencies/edit/{id}', function ($id) {
    return view('admin/currencies/edit', ['currency_id' => $id]);
});


// RATES
Route::get('/admin/rates/list', function () {
    return view('admin/rates/list');
});

Route::get('/admin/rates/add', function () {
    return view('admin/rates/add');
});

Route::get('/admin/rates/edit', function () {
    return view('admin/rates/edit');
});


// BUREAUS
Route::get('/admin/bureaus/list', function () {
    return view('admin/bureaus/list');
});

Route::get('/admin/bureaus/add', function () {
    return view('admin/bureaus/add');
});

Route::get('/admin/bureaus/edit/{id}', function ($id) {
    return view('admin/bureaus/edit', ['bureau_id' => $id]);
});

//CHANGE PASSWORD
Route::get('/admin/security/change', function () {
    return view('admin/security/add');
});


// ADMINS
Route::get('/admin/admins/add', function () {
    return view('admin/admins/add');
});

Route::get('/admin/admins/list', function () {
    return view('admin/admins/list');
});

Route::get('/admin/admins/edit/{id}', function ($id) {
    return view('admin/admins/edit', ['admin_id' => $id]);
});


/*
|--------------------------------------------------------------------------
| BUREAU ROUTES  ---------- WEB  ---------- WEB  ---------- WEB
|--------------------------------------------------------------------------
*/

//LOGIN
Route::get('/', function () {
    return view('bureau/login');
});

Route::get('/login', function () {
    return view('bureau/login');
});

Route::get('/bureau/verification', function () {
    return view('bureau/otp');
});

Route::get('/bureau/dashboard', function () {
    return view('bureau/dashboard');
});

// CUSTOMERS
Route::get('/bureau/customers/add', function () {
    return view('bureau/customers/add');
});
Route::get('/customers/add', function () {
    return view('bureau/customers/add');
});


// RATES
Route::get('/bureau/rates/list', function () {
    return view('bureau/rates/list');
});

Route::get('/bureau/rates/add', function () {
    return view('bureau/rates/add');
});

Route::get('/bureau/rates/edit', function () {
    return view('bureau/rates/edit');
});

// STOCKS
Route::get('/bureau/stocks/list', function () {
    return view('bureau/stocks/list');
});

Route::get('/bureau/stocks/add', function () {
    return view('bureau/stocks/add');
});

// TRADES
Route::get('/bureau/trades/add', function () {
    return view('bureau/trades/add');
});

Route::get('/bureau/trades/edit', function () {
    return view('bureau/trades/edit');
});

// TRANSACTIONS
Route::get('/bureau/transactions/list', function () {
    return view('bureau/trades/list');
});

Route::get('/bureau/transactions/import', function () {
    return view('bureau/trades/import');
});


Route::get('/bureau/transactions/export', function () {
    return view('bureau/trades/export');
});

Route::get('/bureau/transactions/export/pdf/{export_type}/{start_date}/{end_date}/{keyword}', function ($export_type, $start_date, $end_date, $keyword) {
    return view('bureau/trades/export_pdf', ['export_type' => $export_type, 'start_date' => $start_date, 'end_date' => $end_date, 'keyword' => $keyword]);
});


// WORKERS
Route::get('/bureau/workers/add', function () {
    return view('bureau/workers/add');
});

Route::get('/bureau/workers/list', function () {
    return view('bureau/workers/list');
});

Route::get('/bureau/workers/edit/{id}', function ($id) {
    return view('bureau/workers/edit', ['worker_id' => $id]);
});

// BRANCHES
Route::get('/bureau/branches/add', function () {
    return view('bureau/branches/add');
});


//CHANGE PASSWORD
Route::get('/bureau/security/change', function () {
    return view('bureau/security/add');
});

