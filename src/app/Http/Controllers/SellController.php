<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\User;

class SellController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all();
        $conditions = Condition::all();
        return view('users.sell', compact('user', 'categories', 'conditions'));
    }

    public function create(ExhibitionRequest $request)
    {
        dd($request);
        Item::create($request->all());
        return redirect()->back();
    }
}
