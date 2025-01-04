<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    public function users()
    {
        return  $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeExceptCurrentUser($query)
    {
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }
    }

    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            $query->where('item_name', 'like', '%' . $search . '%');
        }
    }

    public function scopeMylist($query, $tab)
    {
        if ((!empty($tab))) {
            return $query->whereHas('favorites', function ($query) {
                $query->where('user_id', Auth::id());
            });
        }
    }
}
