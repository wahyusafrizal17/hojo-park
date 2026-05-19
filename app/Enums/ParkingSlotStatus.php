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
            self::Available => 'border-brand-orange bg-brand-orange-pale text-navy',
            self::Occupied => 'border-navy bg-navy text-white',
            self::Reserved => 'border-brand-orange/60 bg-brand-orange-pale text-navy',
            self::Maintenance => 'border-brand-muted bg-brand-muted/40 text-navy',
        };
    }
}
