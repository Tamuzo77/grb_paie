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
        Schema::table('cotisation_clients', function (Blueprint $table) {
            $table->string('somme_salaires_bruts')->nullable()->change();
            $table->string('somme_cotisations')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotisation_clients', function (Blueprint $table) {
            //
        });
    }
};
