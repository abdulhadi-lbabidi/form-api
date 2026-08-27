<?php

namespace App\Filament\Resources\AccountUpgradeds\Pages;

use App\Filament\Resources\AccountUpgradeds\AccountUpgradedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccountUpgradeds extends ListRecords
{
    protected static string $resource = AccountUpgradedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
