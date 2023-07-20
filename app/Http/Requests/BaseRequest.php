<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BaseRequest extends Controller
{
    protected array $params;
    public Request $request;

    public function __construct(Request $request)
    {
        $this->params = $request->all();
        $this->request = $request;
    }

    /**
     * Return the Request Object
     *
     * @return \Illuminate\Http\Request
     */
    public function getParams(): Request
    {
        return $this->request->replace($this->params);
    }
}
