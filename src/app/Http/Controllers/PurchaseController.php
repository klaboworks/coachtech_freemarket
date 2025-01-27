<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Purchase;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        try {
            Gate::authorize('checkItem', $item);
            $payments = Payment::all();
            return view('items.purchase', ['item' => $item], compact('payments'));
        } catch (AuthorizationException) {
            return redirect(route('items.index'))->withErrors(['caution' => '不正なアクセスです']);
        }
    }

    public function editAddress(Item $item)
    {
        try {
            Gate::authorize('checkItem', $item);
            return view('items.shipping-address', ['item' => $item]);
        } catch (AuthorizationException) {
            return redirect(route('items.index'))->withErrors(['caution' => '不正なアクセスです']);
        }
    }

    public function updateAddress(AddressRequest $request, Item $item)
    {
        $request->flash('overwritten_data', $request->all());
        return redirect()->route('purchase.create', ['item' => $item]);
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        try {
            Gate::authorize('checkItem', $item);
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $product = Item::find($request->item_id);

            $session = $this->createCheckoutSession($request, $product);

            return redirect()->away($session->url);
        } catch (AuthorizationException) {
            return redirect(route('items.index'))->withErrors(['caution' => 'エラーが発生しました']);
        }
    }

    private function createCheckoutSession(PurchaseRequest $request, Item $product)
    {
        $paymentMethodTypes = ['card'];
        if ($request->payment_method == 1) {
            $paymentMethodTypes = ['konbini'];
        }

        $session = Session::create([
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $product->price,
                    'product_data' => [
                        'name' => $product->item_name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('mypage'),
            'cancel_url' => route('mypage'),
        ]);

        return $session;
    }

    // public function handleCheckoutSessionCompleted(Request $request)
    // {
    //     // Webhookの署名検証
    //     // ...

    //     $event = $request->json();
    //     $session = $event['data']['object'];

    //     // 決済が完了したら、soldOut関数を呼び出す
    //     $this->soldOut([
    //         'user_id' => $session['customer'], // 顧客IDを取得
    //         'item_id' => $session['line_items'][0]['price']['product'], // 商品IDを取得
    //         // ... その他必要な情報
    //     ]);
    // }

    public function soldOut(Request $request)
    {
        $overwrittenData = session('overwritten_data', []);
        $data = array_merge([
            'user_id' => $request->user_id,
            'item_id' => $request->item_id,
            'payment_id' => $request->payment_id,
            'postal_code' => $request->postal_code,
            'address1' => $request->address1,
            'address2' => $request->address2,
        ], $overwrittenData);
        Purchase::create($data);
        session()->forget('overwritten_data');
        Item::find($request->item_id)->update(['is_sold' => true]);
    }
}
