<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property string $slug
 * @property string $code
 * @property string $nom
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Paiement[] $paiements
 */
class TypePaiement extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    public const AVANCE = 1;

    public const PRET = 2;

    public const SALAIRE = 3;

    public const PRIMES = 4;

    /**
     * @var array
     */
    protected $fillable = ['slug', 'code', 'nom', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paiements()
    {
        return $this->hasMany('App\Models\Paiement');
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
}
