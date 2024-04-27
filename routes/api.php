<?php

use App\Http\Controllers\TokenController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('token', [TokenController::class, 'create'])->name('token.create');

    Route::group(['middleware' => ValidateToken::class], function () {
        Route::get('kayne-quotes', function () {
            return response()->json(['message' => 'I am a god']);
        })->name('kayne');
    });
});