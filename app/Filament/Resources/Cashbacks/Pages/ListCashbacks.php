<?php

namespace App\Filament\Resources\Cashbacks\Pages;

use App\Filament\Resources\Cashbacks\CashbackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCashbacks extends ListRecords
{
    protected static string $resource = CashbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
