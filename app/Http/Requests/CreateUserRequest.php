<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class CreateUserRequest extends BaseRequest
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:5',
                'phone' => 'required',
            ]
        );

        parent::__construct($request);
    }
}
