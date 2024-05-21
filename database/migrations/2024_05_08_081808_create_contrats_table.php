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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Annee::class)->constrained();
            $table->foreignIdFor(\App\Models\Client::class)->constrained();
            $table->foreignIdFor(\App\Models\Employee::class)->constrained();
            $table->string('slug')->unique();
            $table->dateTime('date_signature')->nullable();
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();
            $table->enum('statut', ['En cours', 'Clos', 'suspendu'])->default('En cours');
            $table->integer('salaire_brut')->default(0);
            $table->integer('nb_jours_conges_acquis')->default(0);
            $table->integer('solde_jours_conges_payes')->default(0);
            $table->integer('tauxIts')->default(0);
            $table->boolean('est_cadre')->default(false);
            $table->foreignIdFor(\App\Models\Fonction::class)->nullable()->constrained()->onDelete('SET NULL');
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
        Schema::dropIfExists('contrats');
    }
};
