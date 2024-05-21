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
        Schema::table('primes', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Employee::class)->nullable()->change();
            $table->foreignIdFor(\App\Models\Contrat::class)->references('id')->on('contrats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('primes', function (Blueprint $table) {
            //
        });
    }
};
