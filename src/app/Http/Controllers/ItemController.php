<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::exceptCurrentUser()->Search($request->serach)->get();
        return view('items.index', compact('items'));
    }
}
