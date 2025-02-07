<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\AuthorizationException;


class UserPolicy
{
    public function checkEmailVerified(User $user): Response
    {
        if ($user->hasVerifiedEmail()) {
            return Response::allow();
        }
        throw new AuthorizationException;
    }
}
