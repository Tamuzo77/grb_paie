<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $employee_id
 * @property string $mois
 * @property string $slug
 * @property string $donnees
 * @property int $montant
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Employee $employee
 */
class SoldeCompte extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['employee_id', 'mois', 'slug', 'donnees', 'montant', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    public const SALAIRE_MENSUEL = 'Salaire mensuel';

    public const TREIZIEME_MOIS = 'Treizième mois';

    public const NOMBRE_DE_JOURS_DE_CONGES_PAYES_DU = 'Nombre de jours de congés payés dû';

    public const PREAVIS = 'Préavis';

    public const AVANCE_SUR_SALAIRE = 'Avance sur salaire';

    public const PRET_ENTREPRISE = 'Prêt entreprise';

    public const TOTAL = 'Total';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['employee.nom', 'mois'],
            ],
        ];
    }
}
