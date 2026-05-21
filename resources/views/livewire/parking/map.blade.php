<div class="space-y-6" wire:poll.5s>
    <x-hotel.page-header
        :title="__('Denah Parkir — :zone', ['zone' => $activeAreaEnum->label()])"
        :subtitle="__('Pemantauan real-time slot, check-in, check-out, dan pelacakan plat nomor.')"
    >
        <x-slot name="actions">
            <span class="vuexy-badge">{{ __('Live · 5s') }}</span>
        </x-slot>
    </x-hotel.page-header>

    <div class="flex flex-wrap gap-2">
        @foreach (\App\Enums\ParkingArea::cases() as $area)
            <button
                type="button"
                wire:click="setArea('{{ $area->value }}')"
                @class([
                    'rounded-xl px-4 py-2 text-sm font-semibold transition',
                    'bg-brand-orange text-white shadow-sm' => $activeArea === $area->value,
                    'border border-brand-border bg-white text-navy hover:bg-brand-cream' => $activeArea !== $area->value,
                ])
            >
                {{ $area->label() }}
            </button>
        @endforeach
    </div>

    <div class="vuexy-card flex flex-wrap gap-2 p-4 text-xs">
            <span class="inline-flex items-center gap-1.5 rounded-full border border-brand-orange/30 bg-brand-orange-pale px-3 py-1 font-medium text-navy dark:border-brand-orange/40 dark:bg-[#152a45] dark:text-white">
                <span class="h-2 w-2 rounded-full bg-brand-orange"></span>{{ __('Kosong') }}
            </span>
            <span class="inline-flex items-center gap-1.5 rounded-full border border-navy/20 bg-navy/10 px-3 py-1 font-medium text-navy dark:border-slate-500 dark:bg-slate-700/80 dark:text-white">
                <span class="h-2 w-2 rounded-full bg-navy dark:bg-slate-400"></span>{{ __('Terisi') }}
            </span>
            <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-3 py-1 font-medium text-amber-900 dark:border-amber-800 dark:bg-amber-950/50 dark:text-amber-100">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span>{{ __('Booking') }}
            </span>
            <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-3 py-1 font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                <span class="h-2 w-2 rounded-full bg-slate-400"></span>{{ __('Maintenance') }}
            </span>
    </div>

    <div class="flex flex-col gap-4 xl:flex-row">
        <div class="vuexy-card relative min-w-0 flex-1 overflow-hidden p-4">
            <div class="mb-3 flex items-center justify-between gap-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-brand-orange dark:text-red-300">{{ __('Area Parkir :zone', ['zone' => $activeAreaEnum->label()]) }}</p>
                <p class="text-[10px] text-slate-400 dark:text-slate-500">{{ __('Auto-refresh 5 detik') }}</p>
            </div>

            <div class="relative flex gap-3">
                @if ($activeArea === 'rear')
                    <x-parking.map-rear :slots="$slots" />
                @elseif ($activeArea === 'front')
                    <x-parking.map-front :slots="$slots" />
                @elseif ($activeArea === 'side')
                    <x-parking.map-side :slots="$slots" />
                @endif
            </div>
        </div>
    </div>

    @if ($showModal && ($slot = $slots->firstWhere('id', $selectedSlotId)))
        <div
            class="fixed inset-0 z-50 flex items-end justify-center bg-slate-900/50 p-4 backdrop-blur-sm sm:items-center"
            x-data="{ show: true }"
            x-on:keydown.escape.window="$wire.closeModal()"
        >
            <div
                class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl border border-slate-200/80 bg-white/95 p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-900/95"
                x-show="show"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            >
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-orange">{{ __('Slot') }}</p>
                        <h2 class="text-xl font-bold text-navy">{{ $slot?->displayCode() }}</h2>
                        <p class="text-sm text-brand-muted">{{ __('Status:') }} {{ $slot?->status?->label() }}</p>
                    </div>
                    <button type="button" wire:click="closeModal" class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800 dark:hover:text-slate-200">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>

                <div class="mt-4 flex gap-1 rounded-xl bg-slate-100/80 p-1 text-xs font-medium dark:bg-slate-800/80">
                    <button type="button" wire:click="setTab('detail')" @class(['flex-1 rounded-lg px-2 py-2 transition', 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white' => $modalTab === 'detail', 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' => $modalTab !== 'detail'])>{{ __('Detail') }}</button>
                    @can('checkIn', $slot)
                        <button type="button" wire:click="setTab('checkin')" @class(['flex-1 rounded-lg px-2 py-2 transition', 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white' => $modalTab === 'checkin', 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' => $modalTab !== 'checkin'])>{{ __('Masuk') }}</button>
                        <button type="button" wire:click="setTab('checkout')" @class(['flex-1 rounded-lg px-2 py-2 transition', 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white' => $modalTab === 'checkout', 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' => $modalTab !== 'checkout'])>{{ __('Keluar') }}</button>
                        <button type="button" wire:click="setTab('booking')" @class(['flex-1 rounded-lg px-2 py-2 transition', 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white' => $modalTab === 'booking', 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' => $modalTab !== 'booking'])>{{ __('Booking') }}</button>
                        <button type="button" wire:click="setTab('admin')" @class(['flex-1 rounded-lg px-2 py-2 transition', 'bg-white text-slate-900 shadow-sm dark:bg-slate-900 dark:text-white' => $modalTab === 'admin', 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' => $modalTab !== 'admin'])>{{ __('Admin') }}</button>
                    @endcan
                </div>

                @if ($modalTab === 'detail' && $slot)
                    <div class="mt-5 space-y-4 text-sm">
                        @if ($slot->activeTransaction)
                            @php($t = $slot->activeTransaction)
                            <dl class="grid grid-cols-2 gap-3 rounded-xl border border-slate-200/80 bg-slate-50/80 p-4 dark:border-slate-700 dark:bg-slate-800/50">
                                <div class="col-span-2">
                                    <dt class="text-xs text-slate-500 dark:text-slate-400">{{ __('Nama Tamu') }}</dt>
                                    <dd class="font-semibold text-slate-900 dark:text-white">{{ $t->guest_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-slate-500 dark:text-slate-400">{{ __('No. Kamar') }}</dt>
                                    <dd class="font-medium">{{ $t->room_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-slate-500 dark:text-slate-400">{{ __('Plat') }}</dt>
                                    <dd class="font-mono font-semibold">{{ $t->plate_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-slate-500 dark:text-slate-400">{{ __('Masuk') }}</dt>
                                    <dd>{{ $t->checked_in_at?->timezone(config('app.timezone'))->format('d M Y H:i') }}</dd>
                                </div>
                                <div class="col-span-2">
                                    <dt class="text-xs text-slate-500 dark:text-slate-400">{{ __('Catatan') }}</dt>
                                    <dd>{{ $t->notes ?: '—' }}</dd>
                                </div>
                            </dl>
                        @else
                            <p class="rounded-xl border border-slate-200/80 bg-slate-50/80 p-4 text-slate-600 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-300">
                                {{ __('Tidak ada kendaraan aktif di slot ini.') }}
                            </p>
                        @endif
                    </div>
                @endif

                @if ($modalTab === 'checkin' && $slot)
                    @can('checkIn', $slot)
                        <form wire:submit.prevent="checkInSubmit" class="mt-5 space-y-3 text-sm">
                            <div>
                                <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Nama Tamu') }}</label>
                                <input type="text" wire:model="checkIn.guest_name" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900" />
                                @error('checkIn.guest_name') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('No. Kamar') }}</label>
                                    <input type="text" wire:model="checkIn.room_number" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900" />
                                    @error('checkIn.room_number') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Plat') }}</label>
                                    <input type="text" wire:model="checkIn.plate_number" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm uppercase dark:border-slate-700 dark:bg-slate-900" />
                                    @error('checkIn.plate_number') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Catatan') }}</label>
                                <textarea wire:model="checkIn.notes" rows="2" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900"></textarea>
                            </div>
                            <label class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                                <input type="checkbox" wire:model="checkIn.scan_entry" class="rounded border-slate-300 text-brand-orange" />
                                {{ __('Entri Via Scan / QR') }}
                            </label>
                            <button type="submit" class="btn-primary w-full">{{ __('Simpan Check-In') }}</button>
                        </form>
                    @endcan
                @endif

                @if ($modalTab === 'checkout' && $slot)
                    @can('checkOut', $slot)
                        <div class="mt-5 space-y-3 text-sm">
                            @if ($slot->activeTransaction)
                                @php($t = $slot->activeTransaction)
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Nama Tamu') }}</label>
                                    <p class="mt-1 rounded-xl border border-slate-200/80 bg-slate-50/80 px-3 py-2.5 text-slate-900 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white">{{ $t->guest_name }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('No. Kamar') }}</label>
                                        <p class="mt-1 rounded-xl border border-slate-200/80 bg-slate-50/80 px-3 py-2.5 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white">{{ $t->room_number }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Plat') }}</label>
                                        <p class="mt-1 rounded-xl border border-slate-200/80 bg-slate-50/80 px-3 py-2.5 font-mono uppercase dark:border-slate-700 dark:bg-slate-800/50 dark:text-white">{{ $t->plate_number }}</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Catatan') }}</label>
                                    <p class="mt-1 rounded-xl border border-slate-200/80 bg-slate-50/80 px-3 py-2.5 text-slate-700 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-300">{{ $t->notes ?: '—' }}</p>
                                </div>
                            @else
                                <p class="rounded-xl border border-slate-200/80 bg-slate-50/80 p-4 text-slate-600 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-300">
                                    {{ __('Tidak ada kendaraan aktif di slot ini.') }}
                                </p>
                            @endif
                            <button type="button" wire:click="checkOutSubmit" @disabled(! $slot->activeTransaction) class="btn-danger disabled:cursor-not-allowed disabled:opacity-50">{{ __('Konfirmasi Check-Out') }}</button>
                        </div>
                    @endcan
                @endif

                @if ($modalTab === 'booking' && $slot)
                    @can('book', $slot)
                        <form wire:submit.prevent="bookingSubmit" class="mt-5 space-y-3 text-sm">
                            <div>
                                <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Nama Tamu') }}</label>
                                <input type="text" wire:model="booking.guest_name" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900" />
                                @error('booking.guest_name') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('No. Kamar') }}</label>
                                    <input type="text" wire:model="booking.room_number" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900" />
                                    @error('booking.room_number') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Plat') }}</label>
                                    <input type="text" wire:model="booking.plate_number" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900" />
                                    @error('booking.plate_number') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Dari') }}</label>
                                    <input type="datetime-local" wire:model="booking.reserved_from" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900" />
                                    @error('booking.reserved_from') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Sampai') }}</label>
                                    <input type="datetime-local" wire:model="booking.reserved_until" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900" />
                                    @error('booking.reserved_until') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Catatan') }}</label>
                                <textarea wire:model="booking.notes" rows="2" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900"></textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full">{{ __('Simpan Booking') }}</button>
                        </form>
                    @endcan
                @endif

                @if ($modalTab === 'admin' && $slot)
                    @can('update', $slot)
                        <form wire:submit.prevent="updateSlotStatus" class="mt-5 space-y-3 text-sm">
                            <label class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ __('Status Slot') }}</label>
                            <select wire:model="statusChoice" class="mt-1 w-full rounded-xl border-slate-200 bg-white text-sm dark:border-slate-700 dark:bg-slate-900">
                                @foreach (\App\Enums\ParkingSlotStatus::cases() as $st)
                                    <option value="{{ $st->value }}">{{ $st->label() }}</option>
                                @endforeach
                            </select>
                            @error('statusChoice') <p class="mt-1 text-xs text-brand-danger">{{ $message }}</p> @enderror
                            <button type="submit" class="btn-primary w-full">{{ __('Perbarui Status') }}</button>
                        </form>
                    @endcan
                @endif
            </div>
        </div>
    @endif
</div>
