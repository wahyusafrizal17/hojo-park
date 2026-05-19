@props(['parkingSlot', 'transaction' => null])

@php
    use App\Enums\ParkingSlotStatus;

    $vipAccent = $parkingSlot->isVip() ? ' ring-2 ring-brand-orange/90' : '';
    $vip1Narrow = strcasecmp($parkingSlot->displayCode(), 'VIP 1') === 0
        && (int) $parkingSlot->span_columns > 1;

    $statusClasses = match ($parkingSlot->status) {
        ParkingSlotStatus::Available => 'border-brand-orange bg-brand-orange-pale text-navy shadow-brand-orange/15',
        ParkingSlotStatus::Occupied => $parkingSlot->isVip()
            ? 'border-brand-orange bg-brand-orange text-white shadow-brand-orange/25'
            : 'border-navy bg-navy text-white shadow-navy/25',
        ParkingSlotStatus::Reserved => 'border-brand-orange/60 bg-brand-orange-pale text-navy shadow-brand-orange/10',
        ParkingSlotStatus::Maintenance => 'border-brand-muted bg-brand-muted/40 text-navy shadow-brand-border/50',
        default => 'border-brand-border bg-white text-navy shadow-brand-border/50',
    };
@endphp

<button
    type="button"
    {{ $attributes->merge([
        'class' => "group relative z-10 flex min-h-[3.25rem] flex-col items-center justify-center rounded-lg border-2 px-1 py-1.5 text-center shadow-sm transition duration-200 hover:z-20 hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange/70 {$statusClasses}{$vipAccent} ".($vip1Narrow ? '!w-1/2 !min-w-0 !max-w-none mx-auto' : 'min-w-0'),
    ]) }}
    title="{{ $parkingSlot->displayCode() }} — {{ $parkingSlot->status->label() }}"
>
    <svg class="mb-0.5 h-3.5 w-3.5 shrink-0 opacity-95" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 16h2l1.2-3.6h9.6L18 16h2M6 16h12M7.5 12.4h9"/>
    </svg>
    <span class="text-[11px] font-bold leading-none tracking-tight drop-shadow-sm sm:text-xs">{{ $parkingSlot->displayCode() }}</span>
    @if ($transaction)
        <span class="mt-0.5 line-clamp-1 max-w-full text-[8px] font-semibold leading-tight opacity-95">{{ $transaction->plate_number }}</span>
    @endif
</button>
