<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AnimalController;

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

//protected
Route::group(['middleware' => ['auth:sanctum']], function () {
    //POSTS
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::put('/posts/{slug}', [PostController::class, 'update']);
    //ANIMALS
    Route::post('/animal', [AnimalController::class, 'store']);
    Route::put('/animal/{slug}', [AnimalController::class, 'update']);
    Route::delete('/animal/{id}', [AnimalController::class, 'destroy']);
    //AUTH
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);
});

//public routes

//POST ROUTES
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);

//ANIMAL ROUTES
Route::get('/animal/{type}', [AnimalController::class, 'index']);
Route::get('/animal/show/{slug}', [AnimalController::class, 'show']);

//AUTH ROUTES
Route::post('/login', [AuthController::class, 'login']);