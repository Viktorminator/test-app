<?php

namespace App\Http\Requests;


use Illuminate\Http\Request;

class CreateCompanyRequest extends BaseRequest
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request, [
                'title' => 'required',
                'phone' => 'required',
                'description' => 'required',
            ]
        );

        parent::__construct($request);
    }
}
