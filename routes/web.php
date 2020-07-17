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

<<<<<<< HEAD
/*
|--------------------------------------------------------------------------
| ADMIN ROUTES  ---------- WEB  ---------- WEB  ---------- WEB
|--------------------------------------------------------------------------
*/

Route::get('/admin/', function () {
    return view('/admin/login');
});

Route::get('/admin/login', function () {
    return view('/admin/login');
});

Route::get('/admin/verification', function () {
    return view('admin/otp');
});

Route::get('/admin/hold', function () {
    return view('admin/otp');
});


Route::get('/admin/dashboard', function () {
    return view('admin/dashboard');
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
=======
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
>>>>>>> 0bbad4b12acda410c74ae099dfdf3e65c08fb551
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