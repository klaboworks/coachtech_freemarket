<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function likeStatus($user_id)
    {
        $liked = Favorite::where('user_id', $user_id)->where('item_id', $this->id)->first();

        if (!$liked) {
            return asset('images/icons/like_inactive.png');
        }
        return asset('images/icons/like_active.png');
    }

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments')
            ->withPivot('comment');
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
            $query->whereHas('favorites', function ($query) {
                $query->where('user_id', Auth::id());
            });
        }
    }

    public function scopeMypage($query, $tab)
    {
        if (!empty($tab)) {
            if ($tab == 'sell') {
                $query->where('user_id', '=', Auth::id());
            } elseif ($tab == 'buy') {
                $query->where('user_id', '!=', Auth::id());
            }
        } else {
            $query->where('user_id', '=', Auth::id());
        }
    }
}
