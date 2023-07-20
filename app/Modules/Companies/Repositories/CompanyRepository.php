<?php
declare(strict_types=1);

namespace App\Modules\Companies\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository
{
    /**
     * @param  int  $userId
     * @return Collection
     */
    public function getCompaniesByUserId(int $userId): Collection
    {
        return Company::where('user_id', $userId)->get();
    }
}
