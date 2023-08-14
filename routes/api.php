<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("register", [UserController::class, "register"])->name('register');
Route::post("login", [UserController::class, "login"])->name('login');

Route::group(["middleware" => ["auth:api"]], function(){
// Route::get('/view',[PostController::class,'create']);
Route::post("logout", [UserController::class, "logout"])->name('logout');

Route::resource('posts', PostController::class);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
