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
        Schema::table('parameters', function (Blueprint $table) {// Champs principaux
            $table->string('site_name')->nullable();          // Nom du site
            $table->string('email')->nullable();              // Email de contact
            $table->string('phone')->nullable();              // Numéro de téléphone
            $table->string('mobile')->nullable();             // Mobile (optionnel)
            $table->text('address')->nullable();              // Adresse complète
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();

            // Logo et images
            $table->string('logo')->nullable();               // Chemin du logo principal (ex: storage/logos/logo.png)
            $table->string('logo_footer')->nullable();        // Logo pour footer
            $table->string('favicon')->nullable();            // Chemin favicon

            // Réseaux sociaux
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();

            // Autres infos utiles
            $table->text('footer_text')->nullable();          // Texte libre pour footer
            $table->text('google_maps_embed')->nullable();    // Code iframe Google Maps
            $table->string('meta_description')->nullable();   // Meta description site
            $table->string('meta_keywords')->nullable();

            // Pour activer/désactiver certaines fonctionnalités
            $table->boolean('maintenance_mode')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->dropColumn('site_name');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('mobile');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('country');

            $table->dropColumn('logo');
            $table->dropColumn('logo_footer');
            $table->dropColumn('favicon');

            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('linkedin');
            $table->dropColumn('youtube');
            $table->dropColumn('tiktok');

            $table->dropColumn('footer_text');
            $table->dropColumn('google_maps_embed');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('maintenance_mode');
        });
    }
};
