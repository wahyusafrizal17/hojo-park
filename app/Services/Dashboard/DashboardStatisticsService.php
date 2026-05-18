<?php

namespace App\Services\Dashboard;

use App\Enums\ParkingArea;
use App\Enums\ParkingSlotStatus;
use App\Models\ParkingSlot;
use App\Models\SystemSetting;
use App\Repositories\Contracts\ParkingTransactionRepositoryInterface;

class DashboardStatisticsService
{
    public function __construct(
        private readonly ParkingTransactionRepositoryInterface $transactions,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function summary(): array
    {
        $total = ParkingSlot::query()->count();
        $occupied = ParkingSlot::query()->where('status', ParkingSlotStatus::Occupied)->count();
        $reserved = ParkingSlot::query()->where('status', ParkingSlotStatus::Reserved)->count();
        $maintenance = ParkingSlot::query()->where('status', ParkingSlotStatus::Maintenance)->count();
        $available = ParkingSlot::query()->where('status', ParkingSlotStatus::Available)->count();

        $today = $this->transactions->todayCount();
        $recent = $this->transactions->recentActivity(10);
        $hourly = $this->transactions->occupancyByHourLastDays(7);

        $usable = max(1, $total - $maintenance);
        $utilization = round((($occupied + $reserved) / $usable) * 100, 1);

        $zones = collect(ParkingArea::cases())->map(function (ParkingArea $area) {
            $base = ParkingSlot::query()->where('area', $area->value);

            return [
                'key' => $area->value,
                'label' => $area->label(),
                'capacity' => (int) match ($area) {
                    ParkingArea::Front => SystemSetting::getValue(SystemSetting::KEY_ZONE_FRONT_CAPACITY, '12'),
                    ParkingArea::Side => SystemSetting::getValue(SystemSetting::KEY_ZONE_SIDE_CAPACITY, '12'),
                    ParkingArea::Rear => SystemSetting::getValue(SystemSetting::KEY_ZONE_REAR_CAPACITY, '30'),
                },
                'total' => (clone $base)->count(),
                'available' => ParkingSlot::query()->where('area', $area->value)->where('status', ParkingSlotStatus::Available)->count(),
                'occupied' => ParkingSlot::query()->where('area', $area->value)->where('status', ParkingSlotStatus::Occupied)->count(),
                'reserved' => ParkingSlot::query()->where('area', $area->value)->where('status', ParkingSlotStatus::Reserved)->count(),
            ];
        });

        return [
            'total_slots' => $total,
            'occupied' => $occupied,
            'reserved' => $reserved,
            'maintenance' => $maintenance,
            'available' => $available,
            'vehicles_today' => $today,
            'recent' => $recent,
            'hourly' => $hourly,
            'utilization' => $utilization,
            'zones' => $zones,
        ];
    }
}
