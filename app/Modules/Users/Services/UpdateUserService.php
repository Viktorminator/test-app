<?php

namespace App\Modules\Users\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UpdateUserService
{
    /**
     * @param $email
     * @return string
     */
    public function update($email): string
    {
        $token = Str::random(30);
        User::where('email', $email)->update(['api_token' => "$token"]);;

        return $token;
    }

    public function resetPassword($user, $newPassword): string
    {
        $user->password = $newPassword;
        $user->save();

        return $this->update($user->email);
    }

    public function resetEmailToken($user): void
    {
        $user->email_token = '';
        $user->save();
    }
}
