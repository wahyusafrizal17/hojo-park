<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parking_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_slot_id')->constrained('parking_slots')->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->restrictOnDelete();
            $table->string('guest_name');
            $table->string('room_number', 32);
            $table->string('plate_number', 32);
            $table->timestamp('checked_in_at');
            $table->timestamp('checked_out_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 32)->default('active');
            $table->uuid('qr_token')->unique();
            $table->boolean('scan_entry')->default(false);
            $table->timestamps();

            $table->index(['status', 'parking_slot_id']);
            $table->index('plate_number');
            $table->index('guest_name');
            $table->index('room_number');
            $table->index('checked_in_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_transactions');
    }
};
