<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class RecoverPasswordRequest extends BaseRequest
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request, [
                'email' => 'required',
                'email_token' => 'required',
            ]
        );

        parent::__construct($request);
    }
}
