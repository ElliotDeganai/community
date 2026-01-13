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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->time('beginning_hour')->default('09:00:00');
            $table->time('ending_hour')->default('19:00:00');
            $table->unsignedInteger('slot_duration_time')->default(1)->nullable();  // Durée (ex: 30, 60, 90…)
            $table->string('availability_type')->nullable();     // Durée (ex: business_day, null)
            $table->string('slot_duration_unit')->default('D');// Durée (ex: H, M…)
            $table->text('description')->nullable();       // Commentaire facultatif
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
