<?php

namespace App\Modules\Companies\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CreateCompanyService
{
    /**
     * @param $params
     * @return Company
     */
    public function create($params): Company
    {
        $user = Auth::user();
        $params['user_id'] = $user->id;

        return Company::create($params);
    }
}
