<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('users.mypage');
    }

    public function edit()
    {
        return view('users.edit');
    }

    public function update(ProfileRequest $request)
    {
        $image = $request->file('avatar');

        if ($image) {
            $path = Storage::put('', $image);
        } else {
            $path = null;
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
