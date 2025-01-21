<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Item;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{
    public function checkItem(User $user, Item $item): Response
    {
        if ($user->id == $item->user_id || $item->is_sold) {
            return Response::deny('No Rights');
        }
        return Response::allow();
    }
}
