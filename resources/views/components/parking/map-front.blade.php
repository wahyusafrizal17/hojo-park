@props(['slots'])

@php
    $map = config('parking-map-front');
    $entrance = $map['entrance_west'];
    $exitEast = $map['exit_east'];
    $exitNe = $map['exit_northeast'];
    $roadPantura = $map['road_pantura'];
@endphp

<div
    class="relative isolate mx-auto min-h-[26rem] w-full max-w-xl flex-1 rounded-2xl border border-slate-200/60 bg-slate-50/80 p-3 shadow-inner dark:border-slate-700/80 dark:bg-slate-900/40"
    style="display:grid;grid-template-columns:repeat({{ $map['grid_columns'] }},minmax(2.75rem,1fr));grid-template-rows:repeat({{ $map['grid_rows'] }},minmax(3rem,auto));gap:0.45rem;"
>
    {{-- Pintu Masuk (barat) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-red-300/60 bg-red-50/90 p-1 text-center text-[9px] font-bold uppercase leading-tight tracking-wide text-red-800 dark:border-red-800 dark:bg-red-950/40 dark:text-red-200"
        style="grid-column:{{ $entrance['coordinate_x'] }}/span {{ $entrance['span_columns'] }};grid-row:{{ $entrance['coordinate_y'] }}/span {{ $entrance['span_rows'] }}"
        aria-hidden="true"
    >
        <span style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg)">{{ __('Pintu Masuk') }}</span>
    </div>

    {{-- Pintu Keluar (timur) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-slate-300/60 bg-slate-100/90 p-1 text-center text-[9px] font-bold uppercase leading-tight text-slate-700 dark:border-slate-600 dark:bg-slate-800/60 dark:text-slate-300"
        style="grid-column:{{ $exitEast['coordinate_x'] }}/span {{ $exitEast['span_columns'] }};grid-row:{{ $exitEast['coordinate_y'] }}/span {{ $exitEast['span_rows'] }}"
        aria-hidden="true"
    >
        <span style="writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg)">{{ __('Pintu Keluar') }}</span>
    </div>

    {{-- Pintu Keluar (timur laut) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-full bg-slate-600 px-1.5 py-1 text-center text-[8px] font-bold uppercase leading-tight text-white shadow-sm dark:bg-slate-500"
        style="grid-column:{{ $exitNe['coordinate_x'] }};grid-row:{{ $exitNe['coordinate_y'] }}"
        aria-hidden="true"
    >
        {{ __('Keluar') }}
    </div>

    {{-- Jalan Pantura (selatan) --}}
    <div
        class="pointer-events-none z-[1] flex items-center justify-center rounded-lg border border-amber-300/60 bg-amber-50/80 px-2 py-1 text-center text-[9px] font-bold uppercase tracking-wide text-amber-900/80 dark:border-amber-900/40 dark:bg-amber-950/30 dark:text-amber-200/90"
        style="grid-column:{{ $roadPantura['coordinate_x'] }}/span {{ $roadPantura['span_columns'] }};grid-row:{{ $roadPantura['coordinate_y'] }}"
        aria-hidden="true"
    >
        {{ __('Jalan Pantura') }}
    </div>

    @foreach ($slots as $slot)
        @php
            $gridStyle = "grid-column: {$slot->coordinate_x} / span {$slot->span_columns}; grid-row: {$slot->coordinate_y} / span {$slot->span_rows}";
            if ($slot->displayCode() === 'VIP 1' && $slot->span_columns > 1) {
                $gridStyle .= '; justify-self: center';
            }
        @endphp
        <x-parking.slot-button
            :parking-slot="$slot"
            :transaction="$slot->activeTransaction"
            wire:click="selectSlot({{ $slot->id }})"
            wire:key="slot-{{ $slot->id }}-{{ $slot->status->value }}-{{ $slot->activeTransaction?->id ?? 'x' }}"
            style="{{ $gridStyle }}"
        />
    @endforeach
</div>
