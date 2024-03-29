<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $annee_id
 * @property int $client_id
 * @property int $bank_id
 * @property string $slug
 * @property string $npi
 * @property string $nom
 * @property string $prenoms
 * @property string $telephone
 * @property string $email
 * @property string $date_naissance
 * @property string $lieu_naissance
 * @property string $situation_matrimoniale
 * @property string $sexe
 * @property int $nb_enfants
 * @property string $date_embauche
 * @property string $date_depart
 * @property string $categorie
 * @property bool $cadre
 * @property int $salaire
 * @property string $numero_compte
 * @property int $tauxIts
 * @property int $tauxCnss
 * @property int $nb_jours_conges_acquis
 * @property int $solde_jours_conges_payes
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Fonction[] $fonctions
 * @property Annee $annee
 * @property Client $client
 * @property Bank $bank
 * @property Absence[] $absences
 * @property Paiement[] $paiements
 * @property DemandeConge[] $demandeConges
 */
class Employee extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['annee_id', 'client_id', 'bank_id', 'slug', 'npi', 'nom', 'prenoms', 'telephone', 'email', 'date_naissance', 'lieu_naissance', 'situation_matrimoniale', 'sexe', 'nb_enfants', 'date_embauche', 'date_depart', 'categorie', 'cadre', 'salaire', 'numero_compte', 'tauxIts', 'tauxCnss', 'nb_jours_conges_acquis', 'solde_jours_conges_payes', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fonctions()
    {
        return $this->belongsToMany('App\Models\Fonction');
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
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeConges()
    {
        return $this->hasMany('App\Models\DemandeConge');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['nom', 'prenoms', 'client.nom'],
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
