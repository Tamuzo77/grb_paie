<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property string $code
 * @property string $nom
 * @property integer $niveau
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property PositionHierachique $positionHierachique
 */
class PositionHierachique extends Model
{
    use Sluggable, SoftDeletes, Userstamps;

    //TODO: Create the resource
    /**
     * @var array
     */
    protected $fillable = ['parent_id', 'slug', 'code', 'nom', 'niveau', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function positionHierachique()
    {
        return $this->belongsTo('App\Models\PositionHierachique', 'parent_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['nom'],
            ],
        ];
    }
}
