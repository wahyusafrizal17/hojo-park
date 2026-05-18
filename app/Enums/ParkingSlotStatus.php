<?php

namespace App\Enums;

enum ParkingSlotStatus: string
{
    case Available = 'available';
    case Occupied = 'occupied';
    case Reserved = 'reserved';
    case Maintenance = 'maintenance';

    public function label(): string
    {
        return match ($this) {
            self::Available => __('Kosong'),
            self::Occupied => __('Terisi'),
            self::Reserved => __('Booking'),
            self::Maintenance => __('Maintenance'),
        };
    }

    public function colorClass(): string
    {
        return match ($this) {
            self::Available => 'bg-emerald-500/90 border-emerald-600 text-white',
            self::Occupied => 'bg-rose-500/90 border-rose-600 text-white',
            self::Reserved => 'bg-amber-400/95 border-amber-500 text-slate-900',
            self::Maintenance => 'bg-slate-400/90 border-slate-500 text-white',
        };
    }
}
