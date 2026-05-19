<div class="space-y-6" wire:poll.15s>
    <x-hotel.page-header
        :title="__('Dashboard Parkir')"
        :subtitle="__('Ringkasan Kapasitas, Aktivitas Terbaru, dan Pola Jam Sibuk.')"
    >
        <x-slot name="actions">
            <a href="{{ route('parking.map') }}" wire:navigate class="btn-secondary gap-2 shadow-sm">
                <svg class="h-4 w-4 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" stroke-linecap="round" d="M9 20.25 3.75 18V5.25L9 7.5l6-2.25 5.25 2.25V18L15 20.25 9 18l-6 2.25Z"/></svg>
                {{ __('Buka Denah') }}
            </a>
        </x-slot>
    </x-hotel.page-header>

    <div class="grid gap-4 sm:grid-cols-3">
        @foreach ($zones as $zone)
            <div class="vuexy-card bg-brand-orange-pale p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-brand-muted">{{ $zone['label'] }}</p>
                <p class="mt-2 text-2xl font-bold text-navy">{{ $zone['available'] }}<span class="text-sm font-normal text-brand-muted"> / {{ $zone['capacity'] }}</span></p>
                <p class="mt-1 text-xs text-brand-muted">{{ __('Kosong · Terisi :o · Booking :r', ['o' => $zone['occupied'], 'r' => $zone['reserved']]) }}</p>
                <a href="{{ route('parking.map', ['area' => $zone['key']]) }}" wire:navigate class="mt-3 inline-block text-xs font-semibold text-brand-orange hover:brightness-110">{{ __('Buka Denah') }} →</a>
            </div>
        @endforeach
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <x-hotel.stat-card :label="__('Total Slot')" :value="$total_slots" :hint="__('Termasuk Maintenance')" icon="grid" tone="primary" />
        <x-hotel.stat-card :label="__('Slot Kosong')" :value="$available" icon="check" tone="success" />
        <x-hotel.stat-card :label="__('Terisi')" :value="$occupied" :hint="__('Booking: :n', ['n' => $reserved])" icon="car" tone="danger" />
        <x-hotel.stat-card :label="__('Kendaraan Hari Ini')" :value="$vehicles_today" :hint="__('Utilisasi: :u%', ['u' => $utilization])" icon="clock" tone="info" />
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <x-hotel.card class="lg:col-span-2" :title="__('Distribusi Check-in Per Jam')" badge="Live">
            @php($maxH = max(array_merge($hourly, [1])))
            <div class="flex h-64 items-end gap-1">
                @foreach ($hourly as $hour => $count)
                    @php($hPct = $maxH > 0 ? round(($count / $maxH) * 100) : 0)
                    <div class="group flex min-w-0 flex-1 flex-col items-center justify-end gap-2">
                        <div
                            class="w-full max-w-[22px] rounded-t-lg bg-gradient-to-t from-brand-orange to-[#f5a623] opacity-90 shadow-sm transition-all duration-300 group-hover:opacity-100"
                            style="height: {{ max(6, $hPct) }}%"
                            title="{{ sprintf('%02d:00 — %d', $hour, $count) }}"
                        ></div>
                        @if ($hour % 3 === 0)
                            <span class="text-[10px] font-medium text-slate-400">{{ sprintf('%02d', $hour) }}</span>
                        @else
                            <span class="h-3"></span>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-hotel.card>

        <x-hotel.card :title="__('Kapasitas Parkir')">
            <div class="space-y-5">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">{{ __('Utilisasi') }}</span>
                    <span class="text-lg font-bold {{ $utilization > 80 ? 'text-brand-danger' : 'text-brand-orange' }}">{{ $utilization }}%</span>
                </div>
                <div class="h-2.5 overflow-hidden rounded-full bg-brand-border/60">
                    <div class="h-full rounded-full transition-all duration-500 {{ $utilization > 80 ? 'bg-brand-danger' : 'bg-brand-orange' }}" style="width: {{ min(100, $utilization) }}%"></div>
                </div>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-800/50">
                        <span class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                            <span class="h-2 w-2 rounded-full bg-brand-orange"></span>{{ __('Kosong') }}
                        </span>
                        <span class="font-semibold">{{ $available }}</span>
                    </li>
                    <li class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-800/50">
                        <span class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                            <span class="h-2 w-2 rounded-full bg-navy"></span>{{ __('Terisi') }}
                        </span>
                        <span class="font-semibold">{{ $occupied }}</span>
                    </li>
                    <li class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-800/50">
                        <span class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>{{ __('Booking') }}
                        </span>
                        <span class="font-semibold">{{ $reserved }}</span>
                    </li>
                    <li class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-slate-800/50">
                        <span class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                            <span class="h-2 w-2 rounded-full bg-slate-400"></span>{{ __('Maintenance') }}
                        </span>
                        <span class="font-semibold">{{ $maintenance }}</span>
                    </li>
                </ul>
            </div>
        </x-hotel.card>
    </div>

    <x-hotel.card :title="__('Aktivitas Terbaru')">
        <x-slot name="header">
            <h2 class="text-[15px] font-semibold text-slate-800 dark:text-white">{{ __('Aktivitas Terbaru') }}</h2>
            <a href="{{ route('parking.map') }}" wire:navigate class="text-sm font-medium text-brand-orange hover:text-brand-orange text-brand-orange">{{ __('Lihat Denah') }} →</a>
        </x-slot>

        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
            @forelse ($recent as $tx)
                <li class="flex items-center justify-between gap-4 py-3.5 first:pt-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-red-500/10 text-brand-orange text-brand-orange">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6"/></svg>
                        </span>
                        <div>
                            <p class="font-medium text-slate-800 dark:text-white">{{ $tx->guest_name }}</p>
                            <p class="text-xs text-slate-500">{{ $tx->plate_number }} · {{ $tx->slot?->slot_code }} · {{ __('Kamar') }} {{ $tx->room_number }}</p>
                        </div>
                    </div>
                    <span class="shrink-0 text-xs font-medium text-slate-400">{{ $tx->checked_in_at?->diffForHumans() }}</span>
                </li>
            @empty
                <li class="py-8 text-center text-sm text-slate-500">{{ __('Belum Ada Aktivitas.') }}</li>
            @endforelse
        </ul>
    </x-hotel.card>
</div>
