<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Sedan', 'code' => 'sedan'],
            ['name' => 'SUV', 'code' => 'suv'],
            ['name' => 'MPV', 'code' => 'mpv'],
            ['name' => 'Motor', 'code' => 'motorcycle'],
        ];

        foreach ($types as $type) {
            VehicleType::query()->firstOrCreate(
                ['code' => $type['code']],
                ['name' => $type['name']],
            );
        }
    }
}
