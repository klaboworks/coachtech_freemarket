<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    public function show(Item $item)
    {
        $purchases = Purchase::where('item_id', $item->id)->get();
        $isBuyer = false;
        $isSeller = false;

        foreach ($purchases as $purchase) {
            if ($purchase->user_id === Auth::id()) {
                $isBuyer = true;
            }
            if ($purchase->seller_id === Auth::id()) {
                $isSeller = true;
            }
        }

        $messages = Deal::where('purchase_id', $purchase->id)->get();

        return view('items.deal', compact('item', 'purchases', 'isBuyer', 'isSeller', 'messages'));
    }

    public function store(Request $request)
    {
        Deal::create($request->all());

        // リダイレクト先のルート名が 'purchase.deal.show' で、ItemモデルのIDを渡したい場合
        // 前の処理で保存した $deal に関連する item_id があると仮定
        return redirect()->route('purchase.deal.show', ['item' => $request->route('item')]);
    }
}
