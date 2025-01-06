<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'detail'])->name('item.detail');

// 会員登録直後ユーザー設定ルーティング
Route::middleware('auth')->group(function () {
    Route::post('/set/profile', [UserController::class, 'updateProfile'])->name('set.profile');
});

// メール認証済みユーザールーティング
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [UserController::class, 'viewProfile'])->name('view.profile');
    Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::post('/mypage/profile', [UserController::class, 'updateProfile'])->name('update.profile');
    Route::post('/item/{item}', [ItemController::class, 'like'])->name('like');
    Route::get('/purchase/{item}', [ItemController::class, 'purchase'])->name('purchase');
});

// メール認証ルーティング
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect(route('items.index'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
