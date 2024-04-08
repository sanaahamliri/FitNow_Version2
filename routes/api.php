<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgressController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [UserController::class, 'createUser']);
Route::post('login', [UserController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {

    Route::resource(['/progress','ProgressController'])->only(['store','index','delete','edit']);
    Route::patch('progress/updateStatus/{progress}', [ProgressController::class, 'updateStatus']);
    Route::get('progress/showUserProgress', [ProgressController::class, 'showUserProgress']);
});
