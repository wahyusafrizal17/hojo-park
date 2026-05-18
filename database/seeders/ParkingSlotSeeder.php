<?php

namespace Database\Seeders;

use App\Enums\ParkingSlotStatus;
use App\Models\ParkingSlot;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class ParkingSlotSeeder extends Seeder
{
    public function run(): void
    {
        $sedanId = VehicleType::query()->where('code', 'sedan')->value('id');
        $this->seedAreaFromConfig('rear', config('parking-map', []), $sedanId);

        ParkingSlot::query()->where('slot_code', 'B.30')->update([
            'status' => ParkingSlotStatus::Maintenance,
        ]);

        $this->seedAreaFromConfig('front', config('parking-map-front', []), $sedanId);
        $this->seedAreaFromConfig('side', config('parking-map-side', []), $sedanId);
    }

    /**
     * @param  array<string, mixed>  $mapConfig
     */
    private function seedAreaFromConfig(string $area, array $mapConfig, ?int $vehicleTypeId): void
    {
        $slots = $mapConfig['slots'] ?? [];
        $validCodes = array_keys($slots);

        foreach ($slots as $slotCode => $coords) {
            ParkingSlot::query()->updateOrCreate(
                ['slot_code' => $slotCode],
                [
                    'area' => $area,
                    'coordinate_x' => $coords['coordinate_x'],
                    'coordinate_y' => $coords['coordinate_y'],
                    'span_columns' => $coords['span_columns'] ?? 1,
                    'span_rows' => $coords['span_rows'] ?? 1,
                    'status' => ParkingSlotStatus::Available,
                    'vehicle_type_id' => $vehicleTypeId,
                ],
            );
        }

        ParkingSlot::query()
            ->where('area', $area)
            ->whereNotIn('slot_code', $validCodes)
            ->delete();
    }

    private function seedSimpleArea(string $area, string $prefix, int $count, ?int $vehicleTypeId): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $slotCode = sprintf('%s.%d', $prefix, $i);

            ParkingSlot::query()->updateOrCreate(
                ['slot_code' => $slotCode],
                [
                    'area' => $area,
                    'coordinate_x' => (($i - 1) % 4) + 1,
                    'coordinate_y' => intdiv($i - 1, 4) + 1,
                    'span_columns' => 1,
                    'span_rows' => 1,
                    'status' => ParkingSlotStatus::Available,
                    'vehicle_type_id' => $vehicleTypeId,
                ],
            );
        }
    }
}
