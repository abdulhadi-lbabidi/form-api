<?php

namespace App\Filament\Resources\Kadrs\Pages;

use App\Filament\Resources\Kadrs\KadrResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKadrs extends ListRecords
{
    protected static string $resource = KadrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
