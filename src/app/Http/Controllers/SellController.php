<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

class SellController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $categories = Category::all();
        $conditions = Condition::all();
        return view('users.sell', compact('user', 'categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $image = $request->file('item_image');
        $path = $image->store('item_images', 'public');
        $priceWithComma = $request->input('price');
        $price = str_replace(',', '', $priceWithComma);
        $item = Item::create([
            'condition_id' => $request->condition_id,
            'user_id' => $request->user_id,
            'item_image' => $path,
            'item_name' => $request->item_name,
            'brand_name' => $request->brand_name,
            'price' => $price,
            'item_description' => $request->item_description,
        ]);
        $item->categories()->sync($request->categories);
        return redirect(route('mypage'))->with('success', '商品を出品しました');
    }
}
