<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $bank_id
 * @property string $slug
 * @property string $matricule
 * @property string $nom
 * @property string $adresse
 * @property string $telephone
 * @property string $email
 * @property string $nom_donneur_ordre
 * @property string $prenom_donneur_ordre
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Bank $bank
 * @property Employee[] $employees
 */
class Client extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['bank_id', 'slug', 'matricule', 'nom', 'adresse', 'telephone', 'email', 'nom_donneur_ordre', 'prenom_donneur_ordre', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'annee_id'];

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
}
