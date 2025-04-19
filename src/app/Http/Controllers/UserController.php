<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::Mypage($request->page)->get();

        if ($request->page == 'deal') {
            $items = $items->sortByDesc(function ($item) {
                $latestDealCreatedAt = $item->purchases()
                    ->where(function ($query) {
                        $query->where('user_id', Auth::id())
                            ->orWhere('seller_id', Auth::id());
                    })
                    ->get()
                    ->flatMap(function ($purchase) {
                        return $purchase->deals()
                            ->where('receiver_id', Auth::id())
                            ->pluck('created_at');
                    })
                    ->max();

                return $latestDealCreatedAt ?? Carbon::create(-9999, 1, 1, 0, 0, 0);
            });
        }

        return view('users.mypage', compact('items'));
    }

    public function edit()
    {
        return view('users.edit');
    }

    public function update(ProfileRequest $request)
    {
        $existImage = Auth::user()->avatar;
        $image = $request->file('avatar');

        if ($image) {
            $path = Storage::put('', $image);
        } else {
            $path = $existImage;
        }

        User::find($request->id)->update([
            'name' => $request->name,
            'avatar' => $path,
            'postal_code' => $request->postal_code,
            'address1' => $request->address1,
            'address2' => $request->address2,
        ]);

        return redirect(route('items.index'))->with('success', 'プロフィールを更新しました');
    }
}
