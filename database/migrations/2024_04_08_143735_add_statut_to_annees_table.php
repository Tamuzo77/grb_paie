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
        Schema::table('annees', function (Blueprint $table) {
            $table->enum('statut', ['en_cours', 'cloture'])->default('en_cours')->after('nom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annees', function (Blueprint $table) {
            //
        });
    }
};
