<?php

namespace App\Models;

use App\Enums\ParkingSlotStatus;
use App\Enums\ParkingTransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_code',
        'area',
        'status',
        'coordinate_x',
        'coordinate_y',
        'span_columns',
        'span_rows',
        'vehicle_type_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => ParkingSlotStatus::class,
        ];
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(ParkingTransaction::class);
    }

    public function activeTransaction(): HasOne
    {
        return $this->hasOne(ParkingTransaction::class)
            ->where('status', ParkingTransactionStatus::Active->value)
            ->latestOfMany('checked_in_at');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(ParkingBooking::class);
    }

    /**
     * Label seragam sesuai denah (B.1, D.5, VIP 1, …).
     */
    public function displayCode(): string
    {
        if (preg_match('/B\.?(\d+)/i', $this->slot_code, $matches)) {
            return 'B.'.(int) $matches[1];
        }

        if (preg_match('/D\.?(\d+)/i', $this->slot_code, $matches)) {
            return 'D.'.(int) $matches[1];
        }

        if (preg_match('/S\.?(\d+)/i', $this->slot_code, $matches)) {
            return 'S.'.(int) $matches[1];
        }

        if (preg_match('/^VIP\s*1/i', $this->slot_code)) {
            return 'VIP 1';
        }

        return $this->slot_code;
    }

    public function isVip(): bool
    {
        return str_starts_with(strtoupper($this->slot_code), 'VIP');
    }
}
