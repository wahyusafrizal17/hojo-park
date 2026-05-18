<?php

namespace App\Livewire\Parking;

use App\Models\User;
use App\Repositories\Contracts\ActivityLogRepositoryInterface;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.hotel')]
#[Title('Activity Log')]
class ActivityLog extends Component
{
    use WithPagination;

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('viewActivityLogs', \App\Models\ParkingSlot::class), 403);
    }

    public function render(ActivityLogRepositoryInterface $logs): View
    {
        return view('livewire.parking.activity-log', [
            'logs' => $logs->paginateRecent(15),
        ]);
    }
}
