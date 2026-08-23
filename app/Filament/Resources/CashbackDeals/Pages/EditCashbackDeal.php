<?php

namespace App\Filament\Resources\CashbackDeals\Pages;

use App\Filament\Resources\CashbackDeals\CashbackDealResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCashbackDeal extends EditRecord
{
    protected static string $resource = CashbackDealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
