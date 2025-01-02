<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    public function scopeExceptCurrentUser($query)
    {
        if (Auth::check()) {
            return $query->where('user_id', '!=', Auth::user()->id);
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('item_name', 'like', '%' . $search . '%');
        }
    }
}
