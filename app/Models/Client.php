<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property integer $id
 * @property integer $bank_id
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
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property Bank $bank
 * @property Employee[] $employees
 */
class Client extends Model
{
    use SoftDeletes, Userstamps, Sluggable;
    /**
     * @var array
     */
    protected $fillable = ['bank_id', 'slug', 'matricule', 'nom', 'adresse', 'telephone', 'email', 'nom_donneur_ordre', 'prenom_donneur_ordre', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

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
                'source' => 'nom'
            ]
        ];
    }
}