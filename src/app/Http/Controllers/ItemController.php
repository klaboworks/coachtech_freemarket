<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Favorite;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::exceptCurrentUser()->Search($request->serach)->get();
        return view('items.index', compact('items'));
    }

    public function detail(Item $item)
    {
        return view('items.detail', ['item' => $item]);
    }

    public function like(Request $request)
    {
        $like = Favorite::where('user_id', Auth::id())->where('Item_id', $request->item_id)->latest()->first();;

        if ($like) {
            Favorite::find($like)->first()->delete();
        } else {
            Favorite::like(Auth::id(), $request->item_id);
        }
        return redirect()->back();
    }
}
