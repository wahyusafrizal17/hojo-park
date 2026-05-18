<?php

namespace App\Repositories\Eloquent;

use App\Enums\ParkingSlotStatus;
use App\Models\ParkingSlot;
use App\Repositories\Contracts\ParkingSlotRepositoryInterface;
use Illuminate\Support\Collection;

class ParkingSlotRepository implements ParkingSlotRepositoryInterface
{
    public function allForMap(?string $area = null): Collection
    {
        return ParkingSlot::query()
            ->when($area, fn ($query) => $query->where('area', $area))
            ->with(['activeTransaction.vehicleType', 'vehicleType'])
            ->orderBy('coordinate_y')
            ->orderBy('coordinate_x')
            ->orderBy('slot_code')
            ->get();
    }

    public function find(int $id): ?ParkingSlot
    {
        return ParkingSlot::query()
            ->with(['activeTransaction.vehicleType', 'vehicleType'])
            ->find($id);
    }

    public function updateStatus(ParkingSlot $slot, ParkingSlotStatus $status): ParkingSlot
    {
        $slot->status = $status;
        $slot->save();

        return $slot->fresh();
    }
}
