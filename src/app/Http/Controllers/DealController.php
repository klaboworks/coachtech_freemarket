<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Requests\DealRequest;
use App\Models\Deal;
use App\Models\Item;
use App\Models\Purchase;

class DealController extends Controller
{
    public function show(Item $item)
    {
        try {
            Gate::authorize('checkRelatedUsers', $item);

            $purchases = Purchase::where('item_id', $item->id)
                ->where(function ($query) {
                    $query->where('user_id', Auth::id())
                        ->orWhere('seller_id', Auth::id());
                })
                ->get();

            $messages = collect();
            if ($purchases->isNotEmpty()) {
                $messages = Deal::where('purchase_id', $purchases->first()->id)->get();
            }

            $isBuyer = $purchases->contains(function ($purchase) {
                return $purchase->user_id === Auth::id();
            });

            $isSeller = $purchases->contains(function ($purchase) {
                return $purchase->seller_id === Auth::id();
            });

            $mySoldItems = Purchase::where('seller_id', Auth::id())
                ->where('deal_done', false)
                ->where('item_id', '!=', $item->id)->get();

            return view('items.deal', compact('item', 'purchases', 'isBuyer', 'isSeller', 'messages', 'mySoldItems'));
        } catch (AuthorizationException) {
            return redirect(route('items.index'))->withErrors(['caution' => '不正なアクセスです']);
        }
    }

    public function store(DealRequest $request)
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

    public function update(DealRequest $request)
    {
        $update_message = $request->only(['deal_message']);

        Deal::find($request->message_id)->update($update_message);
        return redirect()->route('purchase.deal.show', ['item' => $request->route('item')]);
    }

    public function destroy(Request $request)
    {
        Deal::find($request->message_id)->delete();
        return redirect()->route('purchase.deal.show', ['item' => $request->route('item')]);
    }
}
