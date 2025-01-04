<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    public function viewProfile()
    {
        return view('users.mypage');
    }

    public function editProfile()
    {
        return view('users.edit');
    }

    public function updateProfile(ProfileRequest $request)
    {
        $profile = $request->all();
        User::find($request->id)->update($profile);

        return redirect(route('items.index'))->with('success', 'プロフィールを設定しました');
    }
}
