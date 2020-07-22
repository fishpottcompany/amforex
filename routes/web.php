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


/*
|--------------------------------------------------------------------------
| BUREAU ROUTES  ---------- WEB  ---------- WEB  ---------- WEB
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('bureau/login');
});

Route::get('/login', function () {
    return view('bureau/login');
});

Route::get('/rates', function () {
    return view('rates');
});

Route::get('/user', function () {
    return view('user');
});

/*
Route::get('/', function () {
    return view('welcome');
});
*/