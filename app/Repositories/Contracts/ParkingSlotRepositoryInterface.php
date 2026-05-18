<?php

namespace App\Repositories\Contracts;

use App\Enums\ParkingSlotStatus;
use App\Models\ParkingSlot;
use Illuminate\Support\Collection;

interface ParkingSlotRepositoryInterface
{
    public function allForMap(?string $area = null): Collection;

    public function find(int $id): ?ParkingSlot;

    public function updateStatus(ParkingSlot $slot, ParkingSlotStatus $status): ParkingSlot;
}
