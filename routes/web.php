<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
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

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('houses', HouseController::class);
Route::resource('bookings', BookingController::class);
Route::get('/houses/', [HouseController::class, 'index'])->name('houses.index');
Route::resource('contacts', ContactController::class);

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::resource('reviews', ReviewController::class);

Route::get('houses/{house}/photos', 'App\Http\Controllers\HouseController@photos')->name('houses.photos');

Route::get('/welcome',function () {
    return view('welcome');
});