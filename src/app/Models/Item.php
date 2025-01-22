<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    protected $fillable = [
        'condition_id',
        'user_id',
        'item_image',
        'item_name',
        'brand_name',
        'price',
        'item_description',
        'is_sold'
    ];

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
        return $this->belongsToMany(Category::class)->withTimestamps();
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


    public function purchases()
    {
        return $this->belongsToMany(User::class, 'purchases');
    }


    public function getImagePath($imagePath)
    {
        if (!$imagePath) {
            return asset('images/avatar/no_avatar.webp');
        }

        if (file_exists(public_path('images/items/' . $imagePath))) {
            return asset('images/items/' . $imagePath);
        }

        if (file_exists(storage_path('app/public/' . $imagePath))) {
            return asset('storage/' . $imagePath);
        }
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

    public function scopeMylist($query, $page)
    {
        if ((!empty($page))) {
            $query->whereHas('favorites', function ($query) {
                $query->where('user_id', Auth::id());
            });
        }
    }

    public function scopeMypage($query, $page)
    {
        if (!empty($page)) {
            if ($page == 'sell') {
                $query->where('user_id', '=', Auth::id());
            } elseif ($page == 'buy') {
                $query->whereHas('purchases', function ($query) {
                    $query->where('user_id', Auth::id());
                });
            }
        } else {
            $query->where('user_id', '=', Auth::id());
        }
    }
}
