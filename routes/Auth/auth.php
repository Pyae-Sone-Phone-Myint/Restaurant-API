<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\CheckBannedUser;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('user')->controller(AuthController::class)->group(function () {
        Route::get('lists', 'userLists');
        Route::middleware(CheckBannedUser::class)->group(function () {
            Route::get('profile', "userProfile");
            Route::put('edit-profile/{id}', 'editProfile');
            Route::put('edit-profile', 'editYourProfile');
        });
        Route::get('profile/{id}', "checkUserProfile");
        Route::post('create', 'createUser');
        Route::post('{id}/ban', 'banUser');
        Route::post('{id}/un-ban', 'unBanUser');
        Route::post('logout', 'logout');
        Route::post('logout-all', 'logoutAll');
        Route::post('change-password', 'updatePassword');
    });
});
Route::post('login', [AuthController::class, 'login']);
