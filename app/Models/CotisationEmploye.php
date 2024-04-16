<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaracraftTech\LaravelDateScopes\DateScopes;

/**
 * @property integer $id
 * @property integer $client_id
 * @property integer $annee_id
 * @property string $slug
 * @property string $agent
 * @property string $cnss
 * @property string $its
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property Annee $annee
 * @property Client $client
 */
class CotisationEmploye extends Model
{
    use Sluggable, SoftDeletes, Userstamps, DateScopes;
    /**
     * @var array
     */
    protected $fillable = ['client_id', 'annee_id', 'slug', 'agent', 'cnss', 'its', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at', 'total', 'mois'];

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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['agent', 'client.nom', 'mois'],
            ],
        ];
    }
}
