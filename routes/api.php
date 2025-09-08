<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AuthController;

Route::get('/musics/top', [MusicController::class, 'findTopMusics']);
Route::get('/musics', [MusicController::class, 'findAllMusic']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/verify-code', [AuthController::class, 'verifyCode']);


Route::post('/musics', [MusicController::class, 'saveMusic'])->middleware('jwt.verify');
