<?php

namespace App\Repositories\Contracts;

use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ActivityLogRepositoryInterface
{
    public function paginateRecent(int $perPage = 20): LengthAwarePaginator;

    public function log(array $data): ActivityLog;
}
