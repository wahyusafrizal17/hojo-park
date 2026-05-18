<?php

namespace App\Livewire\Dashboard;

use App\Services\Dashboard\DashboardStatisticsService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.hotel')]
#[Title('Dashboard')]
class Overview extends Component
{
    public function render(DashboardStatisticsService $dashboard): View
    {
        return view('livewire.dashboard.overview', $dashboard->summary());
    }
}
