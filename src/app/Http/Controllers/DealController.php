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
        $data = [
            'purchase_id' => $request->purchase_id,
            'buyer_id' => $request->buyer_id,
            'seller_id' => $request->seller_id,
            'deal_message' => $request->deal_message,
        ];

        if ($request->hasFile('additional_image')) {
            $image = $request->file('additional_image');
            $path = $image->store('deal_images', 'public');
            $data['additional_image'] = $path;
        }

        Deal::create($data);

        return redirect()->route('purchase.deal.show', ['item' => $request->route('item')]);
    }
}
