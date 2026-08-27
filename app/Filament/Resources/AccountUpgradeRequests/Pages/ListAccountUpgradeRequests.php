<?php

namespace App\Filament\Resources\AccountUpgradeRequests\Pages;

use App\Filament\Resources\AccountUpgradeRequests\AccountUpgradeRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccountUpgradeRequests extends ListRecords
{
    protected static string $resource = AccountUpgradeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
