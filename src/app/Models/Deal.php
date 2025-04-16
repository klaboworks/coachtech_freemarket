<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        "purchase_id",
        "buyer_id",
        "seller_id",
        "deal_message",
        "additional_image",
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function getSentImage($imagePath)
    {
        if (file_exists(storage_path('app/public/' . $imagePath))) {
            return asset('storage/' . $imagePath);
        }
    }
}
