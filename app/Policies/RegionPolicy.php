<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegionPolicy
{
    public function modify(User $user, Region $region): Response
    {
        return $user->id === $region->user_id
            ? Response::allow()
            : Response::deny('You do not have access to modify region');
    }
}
