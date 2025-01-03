<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    public function users()
    {
        $this->belongsTo(User::class);
    }

    public function comments()
    {
        $this->hasMany(Comment::class);
    }

    public function scopeExceptCurrentUser($query)
    {
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::user()->id);
        }
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('item_name', 'like', '%' . $search . '%');
        }
    }
}
