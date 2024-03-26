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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignIdFor(\App\Models\Annee::class)->nullable()->constrained();
            $table->foreignIdFor(\App\Models\Client::class)->constrained();
            $table->foreignIdFor(\App\Models\Bank::class)->nullable()->constrained();
            $table->string('npi')->nullable();
            $table->string('nom');
            $table->string('prenoms')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->string('sexe')->nullable();
            $table->integer('nb_enfants')->default(0);
            $table->date('date_embauche')->nullable();
            $table->date('date_depart')->nullable();
            $table->string('categorie')->nullable();
            $table->boolean('cadre')->default(false);
            $table->integer('salaire')->default(0);
            $table->string('numero_compte')->nullable();
            $table->integer('tauxIts')->nullable();
            $table->integer('tauxCnss')->nullable();
            $table->integer('nb_jours_conges_acquis')->default(0);
            $table->integer('solde_jours_conges_payes')->default(0);
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
        Schema::dropIfExists('employees');
    }
};
