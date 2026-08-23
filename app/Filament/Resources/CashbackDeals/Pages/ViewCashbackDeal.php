<?php

namespace App\Filament\Resources\CashbackDeals\Pages;

use App\Filament\Resources\CashbackDeals\CashbackDealResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCashbackDeal extends ViewRecord
{
    protected static string $resource = CashbackDealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
