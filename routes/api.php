<?php

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TokenController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('token', [TokenController::class, 'create'])->name('token.create');

    Route::name('quotes.')->prefix('/quotes')->middleware(['middleware' => ValidateToken::class])->group(function () {
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('/refresh', [QuoteController::class, 'refresh'])->name('refresh');
    });
});