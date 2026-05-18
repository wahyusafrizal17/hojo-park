<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function parkingSlots(): HasMany
    {
        return $this->hasMany(ParkingSlot::class);
    }

    public function parkingTransactions(): HasMany
    {
        return $this->hasMany(ParkingTransaction::class);
    }
}
