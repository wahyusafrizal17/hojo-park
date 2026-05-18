<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkingBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_slot_id',
        'vehicle_type_id',
        'guest_name',
        'room_number',
        'plate_number',
        'reserved_from',
        'reserved_until',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'reserved_from' => 'datetime',
            'reserved_until' => 'datetime',
        ];
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(ParkingSlot::class, 'parking_slot_id');
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }
}
