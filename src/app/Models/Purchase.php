<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'payment_id',
        'seller_id',
        'deal_done',
        'seller_rated',
        'postal_code',
        'address1',
        'address2'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function getUnreadDealMessages($userId)
    {
        return $this->deals()
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
