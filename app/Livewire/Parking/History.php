<?php

namespace App\Livewire\Parking;

use App\Repositories\Contracts\ParkingTransactionRepositoryInterface;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.hotel')]
#[Title('Riwayat Parkir')]
class History extends Component
{
    use WithPagination;

    public ?string $date_from = null;

    public ?string $date_to = null;

    public ?string $status = null;

    protected $queryString = [
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render(ParkingTransactionRepositoryInterface $transactions): View
    {
        $filters = array_filter([
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'status' => $this->status,
        ], fn ($v) => $v !== null && $v !== '');

        return view('livewire.parking.history', [
            'rows' => $transactions->paginateForHistory($filters, 12),
        ]);
    }
}
