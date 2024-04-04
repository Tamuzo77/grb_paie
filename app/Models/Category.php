<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property integer $id
 * @property string $slug
 * @property string $nom
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 * @property Employee[] $employees
 */
class Category extends Model
{
    use Sluggable, SoftDeletes, Userstamps;
    /**
     * @var array
     */
    protected $fillable = ['slug', 'nom', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

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
}
