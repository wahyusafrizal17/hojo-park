@props(['slots'])

@php
    $map = config('parking-map-side');
    $roadPublicNorth = $map['road_public_north'];
    $roadPublicSouth = $map['road_public_south'];
    $exitRoad = $map['exit_road'];
    $roadPantura = $map['road_pantura'];
    $eastArea = $map['east_area'];
@endphp

<div
    class="relative isolate min-h-[28rem] max-w-md flex-1 rounded-2xl border border-slate-200/60 bg-slate-50/80 p-3 shadow-inner dark:border-slate-700/80 dark:bg-slate-900/40"
    style="display:grid;grid-template-columns:repeat({{ $map['grid_columns'] }},minmax(3.25rem,1fr));grid-template-rows:repeat({{ $map['grid_rows'] }},minmax(2.75rem,auto));gap:0.4rem;"
>
    {{-- Jalan Umum — blok atas (S.8–S.14) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-slate-300/60 bg-slate-200/50 p-1 text-center text-[9px] font-bold uppercase leading-tight tracking-wide text-slate-600 dark:border-slate-600 dark:bg-slate-800/60 dark:text-slate-300"
        style="grid-column:{{ $roadPublicNorth['coordinate_x'] }}/span {{ $roadPublicNorth['span_columns'] }};grid-row:{{ $roadPublicNorth['coordinate_y'] }}/span {{ $roadPublicNorth['span_rows'] }}"
        aria-hidden="true"
    >
        <span style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg)">{{ __('Jalan Umum') }}</span>
    </div>

    {{-- Jalan Umum — blok bawah (S.7–S.1) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-slate-300/60 bg-slate-200/50 p-1 text-center text-[9px] font-bold uppercase leading-tight tracking-wide text-slate-600 dark:border-slate-600 dark:bg-slate-800/60 dark:text-slate-300"
        style="grid-column:{{ $roadPublicSouth['coordinate_x'] }}/span {{ $roadPublicSouth['span_columns'] }};grid-row:{{ $roadPublicSouth['coordinate_y'] }}/span {{ $roadPublicSouth['span_rows'] }}"
        aria-hidden="true"
    >
        <span style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg)">{{ __('Jalan Umum') }}</span>
    </div>

    {{-- Jalan Keluar (antara S.8 dan S.7) — baris 8 tanpa label Jalan Umum --}}
    <div
        class="pointer-events-none z-[2] flex items-center justify-center rounded-md border border-dashed border-slate-400/70 bg-slate-100/95 px-2 py-1 text-center text-[9px] font-bold uppercase tracking-wide text-slate-600 dark:border-slate-600 dark:bg-slate-800/80 dark:text-slate-300"
        style="grid-column:{{ $exitRoad['coordinate_x'] }}/span {{ $exitRoad['span_columns'] }};grid-row:{{ $exitRoad['coordinate_y'] }}"
        aria-hidden="true"
    >
        {{ __('Jalan Keluar') }}
    </div>

    {{-- Jalan Pantura (selatan) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-amber-300/60 bg-amber-50/80 px-2 py-1 text-center text-[9px] font-bold uppercase tracking-wide text-amber-900/80 dark:border-amber-900/40 dark:bg-amber-950/30 dark:text-amber-200/90"
        style="grid-column:{{ $roadPantura['coordinate_x'] }}/span {{ $roadPantura['span_columns'] }};grid-row:{{ $roadPantura['coordinate_y'] }}"
        aria-hidden="true"
    >
        {{ __('Jalan Pantura') }}
    </div>

    {{-- Area timur (label) --}}
    <div
        class="pointer-events-none z-0 flex items-center justify-center rounded-xl border border-dashed border-slate-300/50 bg-white/40 p-2 text-center text-[10px] font-semibold uppercase leading-snug tracking-wide text-slate-400 dark:border-slate-600 dark:bg-slate-800/30 dark:text-slate-500"
        style="grid-column:{{ $eastArea['coordinate_x'] }}/span {{ $eastArea['span_columns'] }};grid-row:{{ $eastArea['coordinate_y'] }}/span {{ $eastArea['span_rows'] }}"
        aria-hidden="true"
    >
        {{ __('Area Parkir Samping') }}
    </div>

    @foreach ($slots as $slot)
        <x-parking.slot-button
            :parking-slot="$slot"
            :transaction="$slot->activeTransaction"
            wire:click="selectSlot({{ $slot->id }})"
            wire:key="slot-{{ $slot->id }}-{{ $slot->status->value }}-{{ $slot->activeTransaction?->id ?? 'x' }}"
            style="grid-column: {{ $slot->coordinate_x }} / span {{ $slot->span_columns }}; grid-row: {{ $slot->coordinate_y }} / span {{ $slot->span_rows }}"
        />
    @endforeach
</div>
