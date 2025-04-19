<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Category::class, 'category_item')->withTimestamps();
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
        return $this->hasMany(Purchase::class);
    }

    public function sales()
    {
        return $this->hasMany(Purchase::class, 'item_id');
    }

    public function getImagePath($imagePath)
    {
        if (!$imagePath) {
            return asset('images/items/no-image.png');
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
            } elseif ($page == "deal") {
                $query->whereHas('purchases', function ($query) {
                    $query->where(function ($q) {
                        $q->where('user_id', Auth::id())
                            ->orWhere('seller_id', Auth::id());
                    })
                        ->where('deal_done', false);
                });
            }
        } else {
            $query->where('user_id', '=', Auth::id());
        }
    }
}
