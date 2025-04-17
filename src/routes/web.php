<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DealController;
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

// メール認証済みユーザールーティング
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/item/{item}', [ItemController::class, 'like'])->name('like');
    Route::post('/item/comment/{item}', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('purchase.edit.address');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('purchase.update.address');
    Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
    Route::get('/purchase/deal/{item}', [DealController::class, 'show'])->name('purchase.deal.show');
    Route::post('/purchase/deal/{item}', [DealController::class, 'store'])->name('purchase.deal.store');
    Route::patch('/purchase/deal/{item}/update', [DealController::class, 'update'])->name('purchase.deal.update');
    Route::delete('/purchase/deal/{item}/delete', [DealController::class, 'destroy'])->name('purchase.deal.delete');
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('edit.profile');
    Route::post('/mypage/profile', [UserController::class, 'update'])->name('update.profile');
});

// メール認証ルーティング
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect(route('edit.profile'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return redirect(route('verification.notice'))->with('message', '認証メールを送信しました');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
