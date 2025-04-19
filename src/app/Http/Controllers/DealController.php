<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DealCompletedNotification;
use App\Http\Requests\DealRequest;
use App\Models\Deal;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Rating;
use App\Models\User;

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
                $purchase = $purchases->first();
                $messages = Deal::where('purchase_id', $purchase->id)->get();

                // 現在ログインしているユーザーが受信した未読メッセージを既読にする (sender_idとreceiver_idを使用)
                Deal::where('purchase_id', $purchase->id)
                    ->where('receiver_id', Auth::id())
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);
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
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
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

    public function dealDone(Request $request)
    {
        $deal_done = $request->only(['deal_done']);
        $purchase = Purchase::findOrFail($request->purchase_id);
        $purchase->update($deal_done);

        // 出品者、商品、購入者の情報を取得
        $seller = User::findOrFail($purchase->seller_id);
        $item = Item::findOrFail($purchase->item_id);
        $buyer = User::findOrFail($purchase->user_id);

        // 出品者に取引完了メールを送信
        Mail::to($seller->email)->send(new DealCompletedNotification($purchase, $item, $buyer));

        return redirect()->route('purchase.deal.show', ['item' => $request->route('item')]);
    }

    public function rateSeller(Request $request, Purchase $purchase)
    {
        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $rating = new Rating();
            $rating->rater_id = Auth::id(); // 評価を行ったユーザー（購入者）
            $rating->rated_user_id = $purchase->seller_id; // 評価されたユーザー（出品者）
            $rating->purchase_id = $purchase->id;
            $rating->rating = $request->rating;
            $rating->role = 'buyer'; // 評価者の役割
            $rating->save();

            // 購入者が評価したので deal_done を true に更新
            $purchase->update(['deal_done' => true]);

            return redirect()->route('items.index');
        } catch (\Exception) {
            return redirect(route('items.index'))->withErrors(['caution' => '不正なアクセスです']);
        }
    }

    public function rateBuyer(Request $request, Purchase $purchase)
    {
        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $rating = new Rating();
            $rating->rater_id = Auth::id(); // 評価を行ったユーザー（出品者）
            $rating->rated_user_id = $purchase->user_id; // 評価されたユーザー（購入者）
            $rating->purchase_id = $purchase->id;
            $rating->rating = $request->rating;
            $rating->role = 'seller'; // 評価者の役割
            $rating->save();

            // 出品者が評価したので seller_rated を true に更新
            $purchase->update(['seller_rated' => true]);

            return redirect()->route('items.index');
        } catch (\Exception) {
            return redirect(route('items.index'))->withErrors(['caution' => '不正なアクセスです']);
        }
    }
}
