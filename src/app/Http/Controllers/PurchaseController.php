<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function store(PurchaseRequest $request)
    {
        Purchase::create($request->all());
        Item::find($request->item_id)->update(['is_sold' => true]);
        return redirect(route('mypage'));
    }
}
