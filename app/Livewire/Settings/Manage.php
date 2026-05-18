<?php

namespace App\Livewire\Settings;

use App\Enums\ParkingArea;
use App\Models\ParkingSlot;
use App\Models\SystemSetting;
use App\Services\Auth\DualPasswordAuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.hotel')]
#[Title('Pengaturan Sistem')]
class Manage extends Component
{
    public string $tab = 'passwords';

    public string $security_password = '';

    public string $security_password_confirmation = '';

    public string $administrator_password = '';

    public string $administrator_password_confirmation = '';

    public int $zone_front_capacity = 12;

    public int $zone_side_capacity = 12;

    public int $zone_rear_capacity = 30;

    public function mount(): void
    {
        Gate::authorize('manageSettings', ParkingSlot::class);

        $this->zone_front_capacity = (int) SystemSetting::getValue(SystemSetting::KEY_ZONE_FRONT_CAPACITY, '12');
        $this->zone_side_capacity = (int) SystemSetting::getValue(SystemSetting::KEY_ZONE_SIDE_CAPACITY, '12');
        $this->zone_rear_capacity = (int) SystemSetting::getValue(SystemSetting::KEY_ZONE_REAR_CAPACITY, '30');
    }

    public function savePasswords(DualPasswordAuthService $auth): void
    {
        Gate::authorize('manageSettings', ParkingSlot::class);

        $this->validate([
            'security_password' => ['required', 'confirmed', Password::min(6)],
            'administrator_password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $auth->updateSecurityPassword($this->security_password);
        $auth->updateAdministratorPassword($this->administrator_password);

        $this->reset(['security_password', 'security_password_confirmation', 'administrator_password', 'administrator_password_confirmation']);

        session()->flash('hotel_toast', [
            'type' => 'success',
            'message' => __('Kata sandi akses Security dan Administrator berhasil diperbarui.'),
        ]);
    }

    public function saveCapacity(): void
    {
        Gate::authorize('manageSettings', ParkingSlot::class);

        $this->validate([
            'zone_front_capacity' => ['required', 'integer', 'min:1', 'max:200'],
            'zone_side_capacity' => ['required', 'integer', 'min:1', 'max:200'],
            'zone_rear_capacity' => ['required', 'integer', 'min:1', 'max:200'],
        ]);

        SystemSetting::setValue(SystemSetting::KEY_ZONE_FRONT_CAPACITY, (string) $this->zone_front_capacity);
        SystemSetting::setValue(SystemSetting::KEY_ZONE_SIDE_CAPACITY, (string) $this->zone_side_capacity);
        SystemSetting::setValue(SystemSetting::KEY_ZONE_REAR_CAPACITY, (string) $this->zone_rear_capacity);

        session()->flash('hotel_toast', [
            'type' => 'success',
            'message' => __('Kapasitas zona parkir berhasil disimpan.'),
        ]);
    }

    public function render(): View
    {
        $zoneStats = collect(ParkingArea::cases())->map(function (ParkingArea $area) {
            $base = ParkingSlot::query()->where('area', $area->value);

            return [
                'area' => $area,
                'label' => $area->label(),
                'total' => (clone $base)->count(),
                'available' => ParkingSlot::query()->where('area', $area->value)->where('status', 'available')->count(),
                'occupied' => ParkingSlot::query()->where('area', $area->value)->where('status', 'occupied')->count(),
            ];
        });

        return view('livewire.settings.manage', [
            'zoneStats' => $zoneStats,
        ]);
    }
}
