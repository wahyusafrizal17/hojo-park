<?php

namespace App\Services\Parking;

use App\Enums\ActivityAction;
use App\Enums\ParkingSlotStatus;
use App\Enums\ParkingTransactionStatus;
use App\Models\ParkingBooking;
use App\Models\ParkingSlot;
use App\Models\ParkingTransaction;
use App\Models\User;
use App\Repositories\Contracts\ParkingSlotRepositoryInterface;
use App\Repositories\Contracts\ParkingTransactionRepositoryInterface;
use App\Services\Activity\ActivityLogger;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ParkingFlowService
{
    public function __construct(
        private readonly ParkingSlotRepositoryInterface $slots,
        private readonly ParkingTransactionRepositoryInterface $transactions,
        private readonly ActivityLogger $activity,
    ) {}

    public function checkIn(ParkingSlot $slot, array $data, User $actor): ParkingTransaction
    {
        if (! in_array($slot->status, [ParkingSlotStatus::Available, ParkingSlotStatus::Reserved], true)) {
            throw new InvalidArgumentException(__('Slot tidak tersedia untuk check-in.'));
        }

        return DB::transaction(function () use ($slot, $data, $actor) {
            $slot->refresh();

            if ($this->transactions->activeForSlot($slot->id)) {
                throw new InvalidArgumentException(__('Slot masih memiliki kendaraan aktif.'));
            }

            $transaction = ParkingTransaction::query()->create([
                'parking_slot_id' => $slot->id,
                'vehicle_type_id' => $data['vehicle_type_id'],
                'guest_name' => $data['guest_name'],
                'room_number' => $data['room_number'],
                'plate_number' => strtoupper($data['plate_number']),
                'checked_in_at' => now(),
                'notes' => $data['notes'] ?? null,
                'status' => ParkingTransactionStatus::Active,
                'scan_entry' => (bool) ($data['scan_entry'] ?? false),
            ]);

            $slot->status = ParkingSlotStatus::Occupied;
            $slot->save();

            ParkingBooking::query()
                ->where('parking_slot_id', $slot->id)
                ->where('status', 'pending')
                ->update(['status' => 'used']);

            $this->activity->log(
                ActivityAction::CheckIn,
                __('Kendaraan masuk ke :slot', ['slot' => $slot->slot_code]),
                $transaction,
                ['plate' => $transaction->plate_number],
                $actor->id,
            );

            return $transaction->load(['slot', 'vehicleType']);
        });
    }

    public function checkOut(ParkingTransaction $transaction, User $actor): void
    {
        if ($transaction->status !== ParkingTransactionStatus::Active) {
            throw new InvalidArgumentException(__('Transaksi tidak aktif.'));
        }

        DB::transaction(function () use ($transaction, $actor) {
            $transaction->refresh();
            $slot = $transaction->slot;

            $transaction->update([
                'checked_out_at' => now(),
                'status' => ParkingTransactionStatus::Completed,
            ]);

            $slot->status = ParkingSlotStatus::Available;
            $slot->save();

            $this->activity->log(
                ActivityAction::CheckOut,
                __('Kendaraan keluar dari :slot', ['slot' => $slot->slot_code]),
                $transaction,
                ['plate' => $transaction->plate_number],
                $actor->id,
            );
        });
    }

    public function updateSlotStatus(ParkingSlot $slot, ParkingSlotStatus $status, User $actor): ParkingSlot
    {
        return DB::transaction(function () use ($slot, $status, $actor) {
            $slot->refresh();

            if ($status === ParkingSlotStatus::Available && $this->transactions->activeForSlot($slot->id)) {
                throw new InvalidArgumentException(__('Selesaikan check-out sebelum mengosongkan slot.'));
            }

            $before = $slot->status->value;
            $slot = $this->slots->updateStatus($slot, $status);

            $this->activity->log(
                ActivityAction::SlotUpdate,
                __('Status slot :slot diubah', ['slot' => $slot->slot_code]),
                $slot,
                ['from' => $before, 'to' => $status->value],
                $actor->id,
            );

            return $slot;
        });
    }

    public function createBooking(ParkingSlot $slot, array $data, User $actor): ParkingBooking
    {
        if ($slot->status !== ParkingSlotStatus::Available) {
            throw new InvalidArgumentException(__('Slot harus kosong untuk booking.'));
        }

        return DB::transaction(function () use ($slot, $data, $actor) {
            $booking = ParkingBooking::query()->create([
                'parking_slot_id' => $slot->id,
                'vehicle_type_id' => $data['vehicle_type_id'],
                'guest_name' => $data['guest_name'],
                'room_number' => $data['room_number'],
                'plate_number' => isset($data['plate_number']) ? strtoupper($data['plate_number']) : null,
                'reserved_from' => $data['reserved_from'],
                'reserved_until' => $data['reserved_until'],
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            $slot->status = ParkingSlotStatus::Reserved;
            $slot->save();

            $this->activity->log(
                ActivityAction::BookingCreated,
                __('Booking slot :slot', ['slot' => $slot->slot_code]),
                $booking,
                [],
                $actor->id,
            );

            return $booking;
        });
    }
}
