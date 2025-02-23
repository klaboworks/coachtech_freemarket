<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/mypage/profile', [ApiController::class, 'index'])->name('api');
