<?php

namespace App\Repositories\Eloquent;

use App\Enums\ParkingTransactionStatus;
use App\Models\ParkingTransaction;
use App\Repositories\Contracts\ParkingTransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ParkingTransactionRepository implements ParkingTransactionRepositoryInterface
{
    public function paginateForHistory(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = ParkingTransaction::query()
            ->with(['slot', 'vehicleType'])
            ->orderByDesc('checked_in_at');

        if (! empty($filters['date_from'])) {
            $query->whereDate('checked_in_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('checked_in_at', '<=', $filters['date_to']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function activeForSlot(int $slotId): ?ParkingTransaction
    {
        return ParkingTransaction::query()
            ->where('parking_slot_id', $slotId)
            ->where('status', ParkingTransactionStatus::Active)
            ->latest('checked_in_at')
            ->first();
    }

    public function searchLive(string $term): Collection
    {
        $term = trim($term);

        if ($term === '') {
            return collect();
        }

        $like = '%'.str_replace(['%', '_'], ['\\%', '\\_'], $term).'%';

        return ParkingTransaction::query()
            ->with(['slot', 'vehicleType'])
            ->where('status', ParkingTransactionStatus::Active)
            ->where(function ($q) use ($like) {
                $q->where('plate_number', 'like', $like)
                    ->orWhere('guest_name', 'like', $like)
                    ->orWhere('room_number', 'like', $like);
            })
            ->orderByDesc('checked_in_at')
            ->limit(12)
            ->get();
    }

    public function todayCount(): int
    {
        return ParkingTransaction::query()
            ->whereDate('checked_in_at', today())
            ->count();
    }

    public function recentActivity(int $limit = 8): Collection
    {
        return ParkingTransaction::query()
            ->with(['slot', 'vehicleType'])
            ->orderByDesc('checked_in_at')
            ->limit($limit)
            ->get();
    }

    public function occupancyByHourLastDays(int $days = 7): array
    {
        if (DB::getDriverName() === 'sqlite') {
            $rows = ParkingTransaction::query()
                ->select([
                    DB::raw("cast(strftime('%H', checked_in_at) as integer) as h"),
                    DB::raw('COUNT(*) as c'),
                ])
                ->where('checked_in_at', '>=', now()->subDays($days))
                ->groupBy('h')
                ->orderBy('h')
                ->get();
        } else {
            $rows = ParkingTransaction::query()
                ->select([
                    DB::raw('HOUR(checked_in_at) as h'),
                    DB::raw('COUNT(*) as c'),
                ])
                ->where('checked_in_at', '>=', now()->subDays($days))
                ->groupBy('h')
                ->orderBy('h')
                ->get();
        }

        $out = array_fill(0, 24, 0);
        foreach ($rows as $row) {
            $out[(int) $row->h] = (int) $row->c;
        }

        return $out;
    }
}
