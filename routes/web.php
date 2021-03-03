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
    return redirect('login');
   
});

if(session()->has('user')){
    return redirect('welcome');
}

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/categorie', function () {
    return view('home');
})->name('categorie');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/{path?}', function () {
    return view('welcome');
})->where('path','^(?!api).*$');
