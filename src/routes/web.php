<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    //todo: メール認証設定後、'verified'追記
    Route::get('/', [ItemController::class, 'index']);
});
