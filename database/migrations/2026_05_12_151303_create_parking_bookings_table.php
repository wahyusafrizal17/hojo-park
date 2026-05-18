<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parking_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_slot_id')->constrained('parking_slots')->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->restrictOnDelete();
            $table->string('guest_name');
            $table->string('room_number', 32);
            $table->string('plate_number', 32)->nullable();
            $table->timestamp('reserved_from');
            $table->timestamp('reserved_until');
            $table->string('status', 32)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'reserved_until']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_bookings');
    }
};
