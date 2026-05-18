<?php

namespace App\Livewire\Layout;

use App\Repositories\Contracts\ParkingTransactionRepositoryInterface;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $q = '';

    public function render(ParkingTransactionRepositoryInterface $transactions): View
    {
        $results = strlen(trim($this->q)) >= 2
            ? $transactions->searchLive($this->q)
            : collect();

        return view('livewire.layout.global-search', [
            'results' => $results,
        ]);
    }
}
