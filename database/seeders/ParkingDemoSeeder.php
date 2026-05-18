<?php

namespace Database\Seeders;

use App\Enums\ParkingSlotStatus;
use App\Enums\ParkingTransactionStatus;
use App\Models\ParkingBooking;
use App\Models\ParkingSlot;
use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class ParkingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $sedan = VehicleType::query()->where('code', 'sedan')->firstOrFail();
        $suv = VehicleType::query()->where('code', 'suv')->firstOrFail();

        $slotB5 = ParkingSlot::query()->where('slot_code', 'B.5')->firstOrFail();
        $slotB5->update(['status' => ParkingSlotStatus::Occupied]);

        ParkingTransaction::query()->create([
            'parking_slot_id' => $slotB5->id,
            'vehicle_type_id' => $sedan->id,
            'guest_name' => 'Budi Santoso',
            'room_number' => '1204',
            'plate_number' => 'B 1234 XYZ',
            'checked_in_at' => now()->subHours(3),
            'notes' => 'Tamu VIP',
            'status' => ParkingTransactionStatus::Active,
        ]);

        $slotB14 = ParkingSlot::query()->where('slot_code', 'B.14')->firstOrFail();
        $slotB14->update(['status' => ParkingSlotStatus::Reserved]);

        ParkingBooking::query()->create([
            'parking_slot_id' => $slotB14->id,
            'vehicle_type_id' => $sedan->id,
            'guest_name' => 'Dewi Lestari',
            'room_number' => '1509',
            'plate_number' => 'B 9999 AA',
            'reserved_from' => now()->subHour(),
            'reserved_until' => now()->addDay(),
            'status' => 'pending',
            'notes' => 'Booking malam',
        ]);

        $slotB18 = ParkingSlot::query()->where('slot_code', 'B.18')->firstOrFail();
        $slotB18->update(['status' => ParkingSlotStatus::Occupied]);

        ParkingTransaction::query()->create([
            'parking_slot_id' => $slotB18->id,
            'vehicle_type_id' => $suv->id,
            'guest_name' => 'Clara Wijaya',
            'room_number' => '0802',
            'plate_number' => 'D 8877 AB',
            'checked_in_at' => now()->subHour(),
            'status' => ParkingTransactionStatus::Active,
        ]);

        $completedSlot = ParkingSlot::query()->where('slot_code', 'B.3')->firstOrFail();
        ParkingTransaction::query()->create([
            'parking_slot_id' => $completedSlot->id,
            'vehicle_type_id' => $sedan->id,
            'guest_name' => 'Andi Pratama',
            'room_number' => '0501',
            'plate_number' => 'F 2211 GH',
            'checked_in_at' => now()->subDays(1)->setTime(10, 0),
            'checked_out_at' => now()->subDays(1)->setTime(18, 30),
            'status' => ParkingTransactionStatus::Completed,
        ]);
    }
}
