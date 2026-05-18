<?php

namespace App\Policies;

use App\Models\ParkingSlot;
use App\Models\User;

class ParkingSlotPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            User::ROLE_SECURITY,
            User::ROLE_ADMINISTRATOR,
        ]);
    }

    public function view(User $user, ParkingSlot $parkingSlot): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, ParkingSlot $parkingSlot): bool
    {
        return $user->hasAnyRole([
            User::ROLE_SECURITY,
            User::ROLE_ADMINISTRATOR,
        ]);
    }

    public function checkIn(User $user, ParkingSlot $parkingSlot): bool
    {
        return $this->update($user, $parkingSlot);
    }

    public function checkOut(User $user, ParkingSlot $parkingSlot): bool
    {
        return $this->update($user, $parkingSlot);
    }

    public function book(User $user, ParkingSlot $parkingSlot): bool
    {
        return $this->update($user, $parkingSlot);
    }

    public function exportHistory(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function viewHistory(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function viewActivityLogs(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function manageSettings(User $user): bool
    {
        return $user->isAdministrator();
    }
}
