<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EsewaController;

Route::get('/', function () {
    return view('welcome');
});

//
Route::get('esewa-checkout/{product:slug}',[EsewaController::class,'checkout'])->name('esewa.checkout');
Route::get('esewa-verification/{product:slug}',[EsewaController::class,'verification'])->name('esewa.verification');
