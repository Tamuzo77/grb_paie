<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property int $id
 * @property int $client_id
 * @property string $slug
 * @property string $date_debut
 * @property string $date_fin
 * @property int $montant_facture
 * @property string $periode
 * @property int $taux
 * @property int $total_salaire_brut
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property string $deleted_at
 * @property Client $client
 */
class Facturation extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    /**
     * @var array
     */
    protected $fillable = ['client_id', 'slug', 'date_debut', 'date_fin', 'taux', 'total_salaire_brut', 'montant_facture', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['client.nom', 'date_debut', 'date_fin'],
            ],
        ];
    }

    public function getPeriode()
    {
        return Carbon::make($this->date_debut)->format('d/m/Y').' - '.Carbon::make($this->date_fin)->format('d/m/Y');
    }
}
