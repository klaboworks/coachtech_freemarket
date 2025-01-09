<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;

class SellController extends Controller
{
    public function index()
    {
        return view('users.sell');
    }

    public function create(ExhibitionRequest $request)
    {
        Item::create($request->all());
        return redirect()->back();
    }
}
