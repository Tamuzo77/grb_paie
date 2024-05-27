<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{

    const DIRECTRICE_OPERATIONELLE = 'Directrice Opérationnelle';

    const DIRECTRICE_GENERALE = 'Directrice Générale';

    const RESPONSABLE_COMMERCIAL = 'Responsable Commercial';
    use HasFactory;
}
