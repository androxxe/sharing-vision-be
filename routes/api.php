<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

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


Route::get('/article/{limit}/{offset}', [PostController::class, 'index']);
Route::post('/article', [PostController::class, 'store']);
Route::get('/article/{post_id}', [PostController::class, 'show']);
Route::patch('/article/{post_id}', [PostController::class, 'update']);
Route::delete('/article/{post_id}', [PostController::class, 'destroy']);
