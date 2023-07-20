<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class AuthorizeRequest extends BaseRequest
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request, [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        parent::__construct($request);
    }
}
