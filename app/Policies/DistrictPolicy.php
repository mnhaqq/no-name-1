<?php

namespace App\Policies;

use App\Models\District;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DistrictPolicy
{
    public function modify(User $user, District $district): Response
    {
        return $user->id === $district->region->user_id
            ? Response::allow()
            : Response::deny('You do not have access to modify this district.');
    }
}
