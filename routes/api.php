<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\PetController;
use App\Http\Controllers\API\UserController;
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


Route::middleware('auth:sanctum')->group(function () {
    //get Profile
    Route::apiResource('users', UserController::class);
    Route::apiResource('gallery', GalleryController::class);

    Route::get('logout', [UserController::class, 'logout']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('users/login', [UserController::class, 'login']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('pets', PetController::class);
