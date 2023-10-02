<?php

use App\Http\Controllers\Media\PhotoController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('photos', PhotoController::class);
});
