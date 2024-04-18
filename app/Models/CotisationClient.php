<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $client_id
 * @property int $annee_id
 * @property string $slug
 * @property string $agent
 * @property string $somme_salaires_bruts
 * @property string $somme_cotisations
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Client $client
 * @property Annee $annee
 */
class CotisationClient extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['client_id', 'annee_id', 'slug', 'agent', 'somme_salaires_bruts', 'somme_cotisations', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

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
    public function annee()
    {
        return $this->belongsTo('App\Models\Annee');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['agent', 'client.nom', 'annee.nom'],
            ],
        ];
    }
}
