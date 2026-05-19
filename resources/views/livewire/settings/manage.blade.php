<div class="space-y-6">
    <x-hotel.page-header
        :title="__('Pengaturan Sistem')"
        :subtitle="__('Kelola kata sandi dual-level dan kapasitas zona parkir (Depan, Samping, Belakang).')"
    />

    <div class="vuexy-card flex flex-wrap gap-2 p-2">
        <button
            type="button"
            wire:click="$set('tab', 'passwords')"
            @class([
                'rounded-lg px-4 py-2 text-sm font-medium transition',
                'bg-brand-orange text-white shadow-sm' => $tab === 'passwords',
                'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' => $tab !== 'passwords',
            ])
        >
            {{ __('Kata Sandi Akses') }}
        </button>
        <button
            type="button"
            wire:click="$set('tab', 'capacity')"
            @class([
                'rounded-lg px-4 py-2 text-sm font-medium transition',
                'bg-brand-orange text-white shadow-sm' => $tab === 'capacity',
                'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' => $tab !== 'capacity',
            ])
        >
            {{ __('Kapasitas Zona') }}
        </button>
    </div>

    @if ($tab === 'passwords')
        <div class="vuexy-card max-w-2xl p-6">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-white">{{ __('Dual-Level Password') }}</h3>
            <p class="mt-1 text-sm text-slate-500">{{ __('Tanpa username — peran ditentukan otomatis dari kata sandi yang dimasukkan saat login.') }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('Minimal 4 karakter, maksimal 20. Kosongkan bagian yang tidak ingin diubah.') }}</p>

            <form wire:submit="savePasswords" class="mt-6 space-y-5">
                <div class="space-y-4 rounded-xl border border-slate-200/80 p-4 dark:border-slate-700">
                    <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">{{ __('Security (Operasional)') }}</p>
                    <div>
                        <label class="mb-1 block text-sm font-medium">{{ __('Kata sandi baru') }}</label>
                        <input type="password" wire:model="security_password" maxlength="20" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-900" />
                        <x-input-error :messages="$errors->get('security_password')" class="mt-1" />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">{{ __('Konfirmasi') }}</label>
                        <input type="password" wire:model="security_password_confirmation" maxlength="20" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-900" />
                    </div>
                </div>

                <div class="space-y-4 rounded-xl border border-slate-200/80 p-4 dark:border-slate-700">
                    <p class="text-xs font-semibold uppercase tracking-wider text-brand-orange">{{ __('Administrator (Manajerial)') }}</p>
                    <div>
                        <label class="mb-1 block text-sm font-medium">{{ __('Kata sandi baru') }}</label>
                        <input type="password" wire:model="administrator_password" maxlength="20" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-900" />
                        <x-input-error :messages="$errors->get('administrator_password')" class="mt-1" />
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">{{ __('Konfirmasi') }}</label>
                        <input type="password" wire:model="administrator_password_confirmation" maxlength="20" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-900" />
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    {{ __('Simpan Kata Sandi') }}
                </button>
            </form>
        </div>
    @else
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="vuexy-card p-6">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-white">{{ __('Konfigurasi Kapasitas') }}</h3>
                <p class="mt-1 text-sm text-slate-500">{{ __('Batas maksimum slot per zona untuk perencanaan operasional.') }}</p>

                <form wire:submit="saveCapacity" class="mt-6 space-y-4">
                    @foreach ([
                        ['label' => __('Zona Depan'), 'model' => 'zone_front_capacity'],
                        ['label' => __('Zona Samping'), 'model' => 'zone_side_capacity'],
                        ['label' => __('Zona Belakang'), 'model' => 'zone_rear_capacity'],
                    ] as $field)
                        <div>
                            <label class="mb-1 block text-sm font-medium">{{ $field['label'] }}</label>
                            <input type="number" min="1" wire:model="{{ $field['model'] }}" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-900" />
                            <x-input-error :messages="$errors->get($field['model'])" class="mt-1" />
                        </div>
                    @endforeach
                    <button type="submit" class="btn-primary">
                        {{ __('Simpan Kapasitas') }}
                    </button>
                </form>
            </div>

            <div class="vuexy-card p-6">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-white">{{ __('Status Zona Saat Ini') }}</h3>
                <div class="mt-4 space-y-3">
                    @foreach ($zoneStats as $stat)
                        <div class="rounded-xl border border-slate-200/80 p-4 dark:border-slate-700">
                            <p class="font-semibold text-slate-800 dark:text-white">{{ $stat['label'] }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ __('Slot aktif: :total · Kosong: :available · Terisi: :occupied', $stat) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
