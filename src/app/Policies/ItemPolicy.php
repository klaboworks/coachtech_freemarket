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

    public function checkRelatedUsers(User $user, Item $item): Response
    {
        foreach ($item->sales as $purchase) {
            if ($purchase->seller_rated == true) {
                return Response::deny('No Rights');
            }
            if ($user->id == $purchase->user_id || $user->id == $purchase->seller_id) {
            }
            return Response::allow();
        }

        return Response::deny('No Rights');
    }
}
