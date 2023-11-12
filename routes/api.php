<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HouseApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\HousePhotoApiController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Api\ContactApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// routes/api.php






// Rotte per House
Route::get('houses', [HouseApiController::class, 'index']);
Route::post('houses', [HouseApiController::class, 'store']);
Route::get('houses/{house}', [HouseApiController::class, 'show']);
Route::put('houses/{house}', [HouseApiController::class, 'update']);
Route::delete('houses/{house}', [HouseApiController::class, 'destroy']);

Route::middleware(['jwt.auth'])->group(function(){
    // Rotte per Booking
    Route::get('bookings', [BookingApiController::class, 'index']);
    Route::post('bookings', [BookingApiController::class, 'store']);
    Route::get('bookings/{booking}', [BookingApiController::class, 'show']);
    Route::put('bookings/{booking}', [BookingApiController::class, 'update']);
    Route::delete('bookings/{booking}', [BookingApiController::class, 'destroy']);
});


// Rotte per HousePhoto
Route::get('house-photos', [HousePhotoApiController::class, 'index']);
Route::post('house-photos', [HousePhotoApiController::class, 'store']);
Route::get('house-photos/{housePhoto}', [HousePhotoApiController::class, 'show']);
Route::put('house-photos/{housePhoto}', [HousePhotoApiController::class, 'update']);
Route::delete('house-photos/{housePhoto}', [HousePhotoApiController::class, 'destroy']);

Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', 'Auth\ApiAuthController@user');
//Route::middleware('auth:api')->post('/logout', 'Auth\ApiAuthController@logout');
Route::post('/logout', [ApiAuthController::class, 'logout']);
Route::middleware('auth.basic')->get('/protected-endpoint', 'SomeController@method');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//creami le rotte per contacts CRUD
Route::get('contacts', [ContactApiController::class, 'index']);
Route::post('contacts', [ContactApiController::class, 'store']);
Route::get('contacts/{contact}', [ContactApiController::class, 'show']);
Route::put('contacts/{contact}', [ContactApiController::class, 'update']);
Route::delete('contacts/{contact}', [ContactApiController::class, 'destroy']);
