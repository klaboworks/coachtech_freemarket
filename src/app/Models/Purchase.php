<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'payment_id',
        'postal_code',
        'address1',
        'address2'
    ];
}
