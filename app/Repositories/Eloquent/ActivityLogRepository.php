<?php

namespace App\Repositories\Eloquent;

use App\Models\ActivityLog;
use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function paginateRecent(int $perPage = 20): LengthAwarePaginator
    {
        return ActivityLog::query()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function log(array $data): ActivityLog
    {
        return ActivityLog::query()->create($data);
    }
}
