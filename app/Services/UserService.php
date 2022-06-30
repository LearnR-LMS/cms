<?php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    public function store($request)
    {
        return $request->all();
    }
}
