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
        Schema::create('position_hierachiques', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->string('nom');
            $table->integer('niveau')->default(1);
            $table->string('description')->nullable();
            $table->foreignId('parent_id')->nullable()->references('id')->on('position_hierachiques')->nullOnDelete();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_hierachiques');
    }
};
