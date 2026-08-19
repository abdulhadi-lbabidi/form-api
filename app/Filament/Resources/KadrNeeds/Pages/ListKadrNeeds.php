<?php

namespace App\Filament\Resources\KadrNeeds\Pages;

use App\Filament\Resources\KadrNeeds\KadrNeedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKadrNeeds extends ListRecords
{
    protected static string $resource = KadrNeedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
