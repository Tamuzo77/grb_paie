<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property string $slug
 * @property string $nom
 * @property string $debut
 * @property string $fin
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Employee[] $employees
 */
class Annee extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['slug', 'nom', 'debut', 'fin', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'statut'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public const STATUT_EN_COURS = 'en_cours';
    public const STATUT_CLOTURE = 'cloture';
    public function employees()
    {
        return $this->hasMany('App\Models\Employee');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nom',
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function hasStatutEnCours()
    {
        return $this->statut == self::STATUT_EN_COURS;
    }
    public function hasStatutCloture()
    {
        return $this->statut == self::STATUT_CLOTURE;
    }
}
