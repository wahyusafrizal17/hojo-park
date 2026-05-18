<?php

namespace App\Models;

use App\Enums\ParkingTransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ParkingTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_slot_id',
        'vehicle_type_id',
        'guest_name',
        'room_number',
        'plate_number',
        'checked_in_at',
        'checked_out_at',
        'notes',
        'status',
        'qr_token',
        'scan_entry',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'checked_out_at' => 'datetime',
            'status' => ParkingTransactionStatus::class,
            'scan_entry' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ParkingTransaction $transaction): void {
            if (empty($transaction->qr_token)) {
                $transaction->qr_token = (string) Str::uuid();
            }
        });
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(ParkingSlot::class, 'parking_slot_id');
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function durationHuman(): ?string
    {
        if (! $this->checked_in_at) {
            return null;
        }

        $end = $this->checked_out_at ?? now();

        return $this->checked_in_at->diffForHumans($end, true);
    }
}
