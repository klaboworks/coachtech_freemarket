<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
