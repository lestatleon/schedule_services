<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->string('channel', 20); // email|whatsapp|sms
            $table->string('type', 50)->nullable(); // p.ej. "reminder_24h"
            $table->dateTime('scheduled_at')->nullable(); // cuándo debe salir
            $table->dateTime('sent_at')->nullable();
            $table->string('status', 20)->default('pending'); // pending|sent|failed
            $table->json('meta')->nullable(); // payload/errores
            $table->timestamps();

            $table->index(['channel', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
