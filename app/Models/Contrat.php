<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $annee_id
 * @property int $client_id
 * @property int $employee_id
 * @property int $fonction_id
 * @property string $slug
 * @property string $date_signature
 * @property string $date_debut
 * @property string $date_fin
 * @property string $statut
 * @property int $salaire_brut
 * @property int $nb_jours_conges_acquis
 * @property int $solde_jours_conges_payes
 * @property int $tauxIts
 * @property bool $est_cadre
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Absence[] $absences
 * @property Paiement[] $paiements
 * @property DemandeConge[] $demandeConges
 * @property Client $client
 * @property Fonction $fonction
 * @property Annee $annee
 * @property Employee $employee
 */
class Contrat extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['annee_id', 'client_id', 'employee_id', 'fonction_id', 'slug', 'date_signature', 'date_debut', 'position_hierachique_id', 'date_fin', 'statut', 'salaire_brut', 'nb_jours_conges_acquis', 'solde_jours_conges_payes', 'tauxIts', 'category_id', 'position_id', 'est_cadre', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absences()
    {
        return $this->hasMany('App\Models\Absence');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paiements()
    {
        return $this->hasMany('App\Models\Paiement');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeConges()
    {
        return $this->hasMany('App\Models\DemandeConge');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fonction()
    {
        return $this->belongsTo('App\Models\Fonction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function positionHierachique()
    {
        return $this->belongsTo('App\Models\PositionHierachique');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function annee()
    {
        return $this->belongsTo('App\Models\Annee');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tauxIts(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value / 100;
            },
        );

    }

    public function misAPieds()
    {
        return $this->hasMany('App\Models\MisAPied');
    }

    public function primes()
    {
        return $this->hasMany('App\Models\Prime');
    }

    public function soldeComptes()
    {
        return $this->hasMany('App\Models\SoldeCompte');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['client.nom', 'employee.nom', 'employee.prenom', 'fonction.nom'],
            ],
        ];
    }
}
