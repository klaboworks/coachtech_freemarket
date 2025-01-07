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

    public function comments()
    {
        return $this->belongsToMany(User::class, 'comments')
            ->withPivot('comment');
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
