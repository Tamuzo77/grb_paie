<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Settings extends Cluster
{
    //    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Généraux';

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationGroup = 'Paramètres';
}
