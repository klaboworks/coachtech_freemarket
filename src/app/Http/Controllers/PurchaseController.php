<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        $payments = Payment::all();
        return view('items.purchase', ['item' => $item], compact('payments'));
    }

    public function editAddress(Item $item)
    {
        return view('items.shipping-address', ['item' => $item]);
    }

    public function updateAddress(AddressRequest $request, Item $item)
    {
        $request->flash('overwritten_data', $request->all());
        return redirect()->route('purchase.create', ['item' => $item]);
    }

    public function store(PurchaseRequest $request)
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

        return redirect(route('mypage'));
    }
}
