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

// ADMIN ROUTES
Route::get('/admin/login', function () {
    return view('login_admin');
});

Route::get('/admin/verification', function () {
    return view('admin/otp_admin');
});

// BUREAU ROUTES
Route::get('/', function () {
    return view('login_bureau');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/user', function () {
    return view('user');
});

/*
Route::get('/', function () {
    return view('welcome');
});
*/