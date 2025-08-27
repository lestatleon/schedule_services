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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('timezone')->default('UTC');
            // offsets en minutos para recordatorios, p.ej. [1440, 60]
            $table->json('reminder_offsets')->nullable();
            // credenciales o flags para proveedores (usar encriptación si guardas secretos)
            $table->json('email_provider_config')->nullable();
            $table->json('sms_provider_config')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
