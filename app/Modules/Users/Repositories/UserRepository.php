<?php

namespace App\Modules\Users\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param $email
     * @return \App\Models\User|null
     */
    public function getByEmail($email):? User
    {
        return User::where('email', $email)->first();
    }
}
