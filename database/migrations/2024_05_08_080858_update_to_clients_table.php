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
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Bank::class)->nullable()->change();
            $table->integer('tauxCnss')->nullable();
            $table->integer('tauxRetenu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Bank::class)->constrained()->change();
            $table->dropColumn('tauxCnss');
        });
    }
};
