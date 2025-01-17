<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ゲストルーティング
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'detail'])->name('item.detail');

// 会員登録直後ユーザー設定ルーティング
Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('edit.profile');
    Route::post('/mypage/profile', [UserController::class, 'update'])->name('update.profile');
});

// メール認証済みユーザールーティング
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::post('/item/{item}', [ItemController::class, 'like'])->name('like');
    Route::post('/item{item}/comment', [CommentController::class, 'create'])->name('comment.create');
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('purchase.edit.address');
    Route::put('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('purchase.update.address');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
    Route::post('/sell', [SellController::class, 'create'])->name('sell.create');
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
