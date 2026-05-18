<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([User::ROLE_SECURITY, User::ROLE_ADMINISTRATOR] as $role) {
            Role::query()->firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $security = User::query()->firstOrCreate(
            ['email' => 'security@hotel.internal'],
            [
                'name' => 'Security Operasional',
                'password' => Hash::make(str()->random(32)),
                'email_verified_at' => now(),
            ],
        );
        $security->syncRoles([User::ROLE_SECURITY]);

        $administrator = User::query()->firstOrCreate(
            ['email' => 'administrator@hotel.internal'],
            [
                'name' => 'Administrator Manajerial',
                'password' => Hash::make(str()->random(32)),
                'email_verified_at' => now(),
            ],
        );
        $administrator->syncRoles([User::ROLE_ADMINISTRATOR]);
    }
}
