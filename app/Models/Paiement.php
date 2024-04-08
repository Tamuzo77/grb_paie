<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $employee_id
 * @property int $type_paiement_id
 * @property int $mode_paiement_id
 * @property string $slug
 * @property string $date_debut
 * @property string $date_fin
 * @property int $solde
 * @property string $statut
 * @property string $date_paiement
 * @property int $annee_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Employee $employee
 * @property TypePaiement $typePaiement
 * @property ModePaiement $modePaiement
 */
class Paiement extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['employee_id', 'type_paiement_id', 'mode_paiement_id', 'slug', 'date_debut', 'date_fin', 'solde', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'statut', 'annee_id', 'date_paiement', 'pas', 'reste'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typePaiement()
    {
        return $this->belongsTo('App\Models\TypePaiement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modePaiement()
    {
        return $this->belongsTo('App\Models\ModePaiement');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['employee.nom', 'employee.prenoms', 'date_debut', 'date_fin'],
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
