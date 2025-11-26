<?php

namespace App\Policies;

use App\Models\District;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DistrictPolicy
{
    public function modify(): Response
    {
        return Response::allow();
    }
}
