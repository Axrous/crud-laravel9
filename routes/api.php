<?php

use App\Http\Controllers\UsersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/user/data', [UsersController::class, 'postUsers']);
Route::get('/users', [UsersController::class, 'getAllUsers']);
Route::get('/users/{id}', [UsersController::class, 'getUserById']);
Route::put('/users/{id}', [UsersController::class, 'editUser']);
Route::delete('/users/delete/{id}', [UsersController::class, 'deleteUser']);
