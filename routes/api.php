<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */
Route::post('/registration', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/refresh', [AuthController::class,'refresh']);
Route::post('/logout', [AuthController::class,'logout']);

//profile Route
Route::get('/users', [UserProfileController::class,'index']);
Route::get('/users/profile', [UserProfileController::class,'profile']);
Route::put('/users/update-profile/{id}', [UserProfileController::class,'profile_profile']);
Route::delete('/users/delete/{id}', [UserProfileController::class,'destroy']);
 //Route::resource('/users', AuthController::class);

