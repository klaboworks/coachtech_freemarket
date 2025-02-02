<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'condition'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
