<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('npi')->unique()->change();
            $table->string('telephone')->unique()->change();
            $table->string('email')->unique()->change();
            $table->string('numero_compte')->integer()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('npi')->nullable()->change();
            $table->string('telephone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('numero_compte')->nullable()->change();
        });
    }
};
