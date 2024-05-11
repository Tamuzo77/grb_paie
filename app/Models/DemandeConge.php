<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $employee_id
 * @property string $slug
 * @property string $date_debut
 * @property string $date_fin
 * @property string $statut
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Employee $employee
 */
class DemandeConge extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['employee_id', 'contrat_id', 'slug', 'date_debut', 'date_fin', 'statut', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Contrat', 'contrat_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['employee.employee.nom', 'employee.employee.prenoms', 'date_debut', 'date_fin'],
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
