<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AuthController;



Route::get('/', function () {
    return view('upload_img');
})->name('upload_img');


Route::post('/upload', [FileController::class, 'store'])->name('upload');
// routes/web.php


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);



