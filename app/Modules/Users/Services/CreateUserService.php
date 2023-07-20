<?php

namespace App\Modules\Users\Services;

use App\Models\User;

class CreateUserService
{
    /**
     * @param $params
     */
    public function create($params)
    {
        $user = new User($params);
        $user->password = $params['password'];
        $user->save();

        return $user;
    }
}
