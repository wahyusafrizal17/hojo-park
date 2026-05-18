@props(['slots'])

@php
    $map = config('parking-map');
    $motor = $map['motor_area'];
    $roadEast = $map['road_east'];
    $entrance = $map['entrance'];
@endphp

<div
    class="relative isolate min-h-[22rem] w-full flex-1 rounded-2xl border border-slate-200/60 bg-slate-50/80 p-3 shadow-inner dark:border-slate-700/80 dark:bg-slate-900/40"
    style="display:grid;grid-template-columns:repeat({{ $map['grid_columns'] }},minmax(2.75rem,1fr));grid-template-rows:repeat({{ $map['grid_rows'] }},minmax(3.5rem,auto));gap:0.5rem;"
>
    {{-- Lorong horizontal antara baris slot --}}
    <div class="pointer-events-none z-0 rounded-md bg-slate-200/40 dark:bg-slate-800/40" style="grid-column:1 / 12;grid-row:2" aria-hidden="true"></div>
    <div class="pointer-events-none z-0 rounded-md bg-slate-200/40 dark:bg-slate-800/40" style="grid-column:16;grid-row:2" aria-hidden="true"></div>
    <div class="pointer-events-none z-0 rounded-md bg-slate-200/40 dark:bg-slate-800/40" style="grid-column:1 / 11;grid-row:4" aria-hidden="true"></div>
    <div class="pointer-events-none z-0 rounded-md bg-slate-200/40 dark:bg-slate-800/40" style="grid-column:16;grid-row:4" aria-hidden="true"></div>

    {{-- Celah baris bawah antara B.22 dan B.23 --}}
    <div class="pointer-events-none z-0 rounded-md bg-slate-200/30 dark:bg-slate-800/30" style="grid-column:3 / 8;grid-row:5" aria-hidden="true"></div>

    {{-- Area Parkir Motor --}}
    <div
        class="pointer-events-none z-[1] flex h-full min-h-0 items-center justify-center rounded-xl border-2 border-dashed border-red-300/80 bg-red-50/70 p-2 text-center text-[10px] font-bold uppercase leading-tight tracking-wide text-red-700/90 dark:border-red-800/60 dark:bg-red-950/40 dark:text-red-200/90"
        style="grid-column:{{ $motor['coordinate_x'] }}/span {{ $motor['span_columns'] }};grid-row:{{ $motor['coordinate_y'] }}/span {{ $motor['span_rows'] }}"
        aria-hidden="true"
    >
        {{ __('Area Parkir Motor') }}
    </div>

    {{-- Jalan Umum (timur) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-slate-300/60 bg-slate-200/50 p-1 text-center text-[9px] font-bold uppercase leading-tight tracking-wide text-slate-600 dark:border-slate-600 dark:bg-slate-800/60 dark:text-slate-300"
        style="grid-column:{{ $roadEast['coordinate_x'] }}/span {{ $roadEast['span_columns'] }};grid-row:{{ $roadEast['coordinate_y'] }}/span {{ $roadEast['span_rows'] }}"
        aria-hidden="true"
    >
        <span style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg)">{{ __('Jalan Umum') }}</span>
    </div>

    {{-- Pintu Masuk (lorong di atas B.26–B.30) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-red-400/70 bg-red-600/90 px-2 py-1.5 text-center text-[9px] font-bold uppercase tracking-wide text-white shadow-sm"
        style="grid-column:{{ $entrance['coordinate_x'] }}/span {{ $entrance['span_columns'] }};grid-row:{{ $entrance['coordinate_y'] }}/span {{ $entrance['span_rows'] }}"
        aria-hidden="true"
    >
        {{ __('Pintu Masuk') }}
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
