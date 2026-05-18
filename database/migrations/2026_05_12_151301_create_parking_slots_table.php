<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parking_slots', function (Blueprint $table) {
            $table->id();
            $table->string('slot_code', 16)->unique();
            $table->string('area', 64);
            $table->string('status', 32)->default('available');
            $table->unsignedSmallInteger('coordinate_x')->default(1);
            $table->unsignedSmallInteger('coordinate_y')->default(1);
            $table->unsignedTinyInteger('span_columns')->default(1);
            $table->unsignedTinyInteger('span_rows')->default(1);
            $table->foreignId('vehicle_type_id')->nullable()->constrained('vehicle_types')->nullOnDelete();
            $table->timestamps();

            $table->index(['coordinate_y', 'coordinate_x']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_slots');
    }
};
