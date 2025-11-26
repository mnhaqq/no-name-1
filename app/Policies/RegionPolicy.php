<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegionPolicy
{
    public function modify(): Response
    {
        return Response::allow();
    }
}
