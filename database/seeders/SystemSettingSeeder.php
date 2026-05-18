<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        SystemSetting::setValue(
            SystemSetting::KEY_SECURITY_PASSWORD,
            Hash::make(env('SECURITY_ACCESS_PASSWORD', 'security123')),
        );

        SystemSetting::setValue(
            SystemSetting::KEY_ADMINISTRATOR_PASSWORD,
            Hash::make(env('ADMINISTRATOR_ACCESS_PASSWORD', 'admin123')),
        );

        SystemSetting::setValue(
            SystemSetting::KEY_ZONE_FRONT_CAPACITY,
            (string) config('parking-areas.front.default_capacity', 12),
        );

        SystemSetting::setValue(
            SystemSetting::KEY_ZONE_SIDE_CAPACITY,
            (string) config('parking-areas.side.default_capacity', 14),
        );

        SystemSetting::setValue(
            SystemSetting::KEY_ZONE_REAR_CAPACITY,
            (string) config('parking-areas.rear.default_capacity', 30),
        );
    }
}
