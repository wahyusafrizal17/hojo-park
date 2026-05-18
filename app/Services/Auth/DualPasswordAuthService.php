<?php

namespace App\Services\Auth;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DualPasswordAuthService
{
    public function authenticate(string $password): ?User
    {
        $adminHash = SystemSetting::getValue(SystemSetting::KEY_ADMINISTRATOR_PASSWORD);
        $securityHash = SystemSetting::getValue(SystemSetting::KEY_SECURITY_PASSWORD);

        if ($adminHash && Hash::check($password, $adminHash)) {
            return User::query()->role(User::ROLE_ADMINISTRATOR)->first();
        }

        if ($securityHash && Hash::check($password, $securityHash)) {
            return User::query()->role(User::ROLE_SECURITY)->first();
        }

        return null;
    }

    public function updateSecurityPassword(string $plainPassword): void
    {
        SystemSetting::setValue(
            SystemSetting::KEY_SECURITY_PASSWORD,
            Hash::make($plainPassword),
        );
    }

    public function updateAdministratorPassword(string $plainPassword): void
    {
        SystemSetting::setValue(
            SystemSetting::KEY_ADMINISTRATOR_PASSWORD,
            Hash::make($plainPassword),
        );
    }
}
