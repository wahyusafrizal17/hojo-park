<?php

namespace App\Repositories\Contracts;

use App\Models\ParkingTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ParkingTransactionRepositoryInterface
{
    public function paginateForHistory(array $filters, int $perPage = 15): LengthAwarePaginator;

    public function activeForSlot(int $slotId): ?ParkingTransaction;

    public function searchLive(string $term): Collection;

    public function todayCount(): int;

    public function recentActivity(int $limit = 8): Collection;

    /**
     * @return array<int, int> hour => count
     */
    public function occupancyByHourLastDays(int $days = 7): array;
}
