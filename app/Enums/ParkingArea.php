<?php

namespace App\Enums;

enum ParkingArea: string
{
    case Front = 'front';
    case Side = 'side';
    case Rear = 'rear';

    public function label(): string
    {
        return match ($this) {
            self::Front => __('Depan'),
            self::Side => __('Samping'),
            self::Rear => __('Belakang'),
        };
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
