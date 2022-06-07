<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
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

Route::group(['middleware' => ['auth:api']], function(){
       Route::get('profile', [UserController::class, 'profile']);
       Route::get('logout', [UserController::class, 'logout']);
       // posts route
       Route::get('post-list', [PostController::class, 'index']);
       Route::post('post-store', [PostController::class, 'store']);
       Route::put('post-update/{id}', [PostController::class, 'update']);
       Route::delete('post-delete/{id}', [PostController::class, 'destroy']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
