<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * @property integer $id
 * @property string $slug
 * @property string $nom
 * @property string $adresse
 * @property string $telephone
 * @property string $email
 * @property string $logo
 * @property string $slogan
 * @property string $directeur
 * @property string $signature
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $deleted_at
 */
class Company extends Model
{
    use Sluggable, SoftDeletes, Userstamps;
    /**
     * @var array
     */
    protected $fillable = ['slug', 'nom', 'adresse', 'telephone', 'email', 'logo', 'slogan', 'directeur', 'signature', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nom',
            ],
        ];
    }

//    public function logo(): Attribute
//    {
//        return Attribute::make(
//          set: function ($value) {
//              return $value->store('logos', 'public');
//          },
//        );
//    }
}
