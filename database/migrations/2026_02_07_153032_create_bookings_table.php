<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');

            // Konteks Fotografer
            $table->string('package'); // Misal: Pre-Wedding, Graduation
            $table->string('location'); // Misal: Studio, Outdoor Pantai
            $table->dateTime('booking_date'); // Tanggal & Jam sesi foto

            // Catatan
            $table->text('message')->nullable(); // Pesan dari klien
            $table->text('admin_notes')->nullable(); // Catatan rahasia admin

            // Status Booking
            $table->enum('status', ['pending', 'confirmed', 'completed', 'canceled'])->default('pending');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
