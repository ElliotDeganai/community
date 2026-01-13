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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('meeting_date');          // Date et heure du rendez-vous
            $table->unsignedInteger('duration_time');  // Durée (ex: 30, 60, 90…)
            $table->string('duration_unit');      // Durée (ex: 30, 60, 90…)
            $table->string('status');
            $table->text('comment')->nullable();       // Commentaire facultatif
            $table->integer('user_id');
            $table->string('type')->nullable();        // Type de rendez-vous (ex: 'consultation', 'rappel', etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
