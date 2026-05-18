<?php

namespace App\Livewire\Parking;

use App\Enums\ParkingArea;
use App\Enums\ParkingSlotStatus;
use App\Http\Requests\Parking\BookingRequest;
use App\Http\Requests\Parking\CheckInRequest;
use App\Models\ParkingSlot;
use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use App\Repositories\Contracts\ParkingSlotRepositoryInterface;
use App\Services\Parking\ParkingFlowService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.hotel')]
#[Title('Denah Parkir')]
class Map extends Component
{
    public ?int $selectedSlotId = null;

    public bool $showModal = false;

    public string $modalTab = 'detail';

    public ?int $activeTransactionId = null;

    public array $checkIn = [];

    public array $booking = [];

    public string $statusChoice = '';

    public string $activeArea = 'rear';

    protected ParkingSlotRepositoryInterface $slots;

    protected ParkingFlowService $parking;

    public function boot(ParkingSlotRepositoryInterface $slots, ParkingFlowService $parking): void
    {
        $this->slots = $slots;
        $this->parking = $parking;
    }

    public function mount(): void
    {
        $area = request()->query('area');
        if (is_string($area) && in_array($area, ParkingArea::values(), true)) {
            $this->activeArea = $area;
        }

        $this->resetForms();
    }

    public function refreshSlots(): void
    {
        // polling hook — data loaded in render
    }

    public function setArea(string $area): void
    {
        if (! in_array($area, ParkingArea::values(), true)) {
            return;
        }

        $this->activeArea = $area;
        $this->closeModal();
    }

    public function selectSlot(int $id): void
    {
        $slot = ParkingSlot::findOrFail($id);
        Gate::authorize('view', $slot);

        $this->selectedSlotId = $id;
        $this->modalTab = 'detail';
        $this->showModal = true;

        $slot = $this->selectedSlot();

        if ($slot?->activeTransaction) {
            $this->activeTransactionId = $slot->activeTransaction->id;
        } else {
            $this->activeTransactionId = null;
        }

        $this->resetForms();
        $this->statusChoice = $slot?->status?->value ?? ParkingSlotStatus::Available->value;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedSlotId = null;
        $this->activeTransactionId = null;
        $this->resetForms();
    }

    public function setTab(string $tab): void
    {
        $this->modalTab = $tab;
    }

    public function checkInSubmit(): void
    {
        $slot = $this->selectedSlot();

        if (! $slot) {
            return;
        }

        Gate::authorize('checkIn', $slot);

        $validated = $this->validate(CheckInRequest::livewireRules('checkIn'));
        $payload = $validated['checkIn'];

        try {
            $this->parking->checkIn($slot, $payload, auth()->user());
            session()->now('hotel_toast', ['type' => 'success', 'message' => __('Check-in berhasil')]);
            $this->closeModal();
        } catch (\Throwable $e) {
            session()->now('hotel_toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function checkOutSubmit(): void
    {
        $transaction = ParkingTransaction::query()->find($this->activeTransactionId);

        if (! $transaction) {
            session()->now('hotel_toast', ['type' => 'error', 'message' => __('Tidak ada kendaraan aktif.')]);

            return;
        }

        Gate::authorize('checkOut', $transaction->slot);

        try {
            $this->parking->checkOut($transaction, auth()->user());
            session()->now('hotel_toast', ['type' => 'success', 'message' => __('Check-out berhasil')]);
            $this->closeModal();
        } catch (\Throwable $e) {
            session()->now('hotel_toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateSlotStatus(): void
    {
        $slot = $this->selectedSlot();

        if (! $slot) {
            return;
        }

        Gate::authorize('update', $slot);

        $this->validate([
            'statusChoice' => ['required', Rule::enum(ParkingSlotStatus::class)],
        ]);

        try {
            $status = ParkingSlotStatus::from($this->statusChoice);
            $this->parking->updateSlotStatus($slot, $status, auth()->user());
            session()->now('hotel_toast', ['type' => 'success', 'message' => __('Status slot diperbarui')]);
            $this->closeModal();
        } catch (\Throwable $e) {
            session()->now('hotel_toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function bookingSubmit(): void
    {
        $slot = $this->selectedSlot();

        if (! $slot) {
            return;
        }

        Gate::authorize('book', $slot);

        $validated = $this->validate(BookingRequest::livewireRules('booking'));
        $payload = $validated['booking'];

        try {
            $this->parking->createBooking($slot, $payload, auth()->user());
            session()->now('hotel_toast', ['type' => 'success', 'message' => __('Booking dibuat')]);
            $this->closeModal();
        } catch (\Throwable $e) {
            session()->now('hotel_toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    protected function resetForms(): void
    {
        $this->checkIn = [
            'vehicle_type_id' => VehicleType::query()->value('id'),
            'guest_name' => '',
            'room_number' => '',
            'plate_number' => '',
            'notes' => '',
            'scan_entry' => false,
        ];

        $this->booking = [
            'vehicle_type_id' => VehicleType::query()->value('id'),
            'guest_name' => '',
            'room_number' => '',
            'plate_number' => '',
            'reserved_from' => now()->format('Y-m-d\TH:i'),
            'reserved_until' => now()->addHours(4)->format('Y-m-d\TH:i'),
            'notes' => '',
        ];
    }

    public function selectedSlot(): ?ParkingSlot
    {
        if (! $this->selectedSlotId) {
            return null;
        }

        return $this->slots->find($this->selectedSlotId);
    }

    public function render(): View
    {
        $slots = $this->slots->allForMap($this->activeArea);
        $vehicleTypes = VehicleType::query()->orderBy('name')->get();
        $activeAreaEnum = ParkingArea::from($this->activeArea);

        return view('livewire.parking.map', [
            'slots' => $slots,
            'vehicleTypes' => $vehicleTypes,
            'activeAreaEnum' => $activeAreaEnum,
        ]);
    }
}
