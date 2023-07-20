<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class GetCompaniesRequest extends BaseRequest
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
}
