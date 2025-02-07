<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Item;
use App\Models\Favorite;

class ItemController extends Controller
{
    private function renderIndexPage(Request $request)
    {
        session()->put('search_query', $request->search);
        $items = Item::Search($request->search)->ExceptCurrentUser()->Mylist($request->page)->orderBy('id')->get();
        return view('items.index', compact('items'));
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            try {
                $user = Auth::user();
                Gate::authorize('checkEmailVerified', $user);
                return $this->renderIndexPage($request);
            } catch (AuthorizationException) {
                return redirect()->route('verification.notice');
            }
        }
        return $this->renderIndexPage($request);
    }

    public function detail(Item $item)
    {
        if (Auth::check()) {
            try {
                $user = Auth::user();
                Gate::authorize('checkEmailVerified', $user);
                return view('items.detail', ['item' => $item]);
            } catch (AuthorizationException) {
                return redirect()->route('verification.notice');
            }
        }
        return view('items.detail', ['item' => $item]);
    }

    public function like(Request $request)
    {
        $like = Favorite::where('user_id', Auth::id())->where('item_id', $request->item_id)->latest()->first();;

        if ($like) {
            Favorite::find($like)->first()->delete();
        } else {
            Favorite::like(Auth::id(), $request->item_id);
        }
        return redirect()->back();
    }
}
