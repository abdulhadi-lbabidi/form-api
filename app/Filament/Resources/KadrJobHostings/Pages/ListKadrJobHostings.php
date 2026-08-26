<?php

namespace App\Filament\Resources\KadrJobHostings\Pages;

use App\Filament\Resources\KadrJobHostings\KadrJobHostingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKadrJobHostings extends ListRecords
{
    protected static string $resource = KadrJobHostingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
