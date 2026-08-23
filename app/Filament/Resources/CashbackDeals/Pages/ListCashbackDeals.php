<?php

namespace App\Filament\Resources\CashbackDeals\Pages;

use App\Filament\Resources\CashbackDeals\CashbackDealResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCashbackDeals extends ListRecords
{
    protected static string $resource = CashbackDealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
