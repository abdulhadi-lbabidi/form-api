<?php

namespace App\Filament\Resources\CashbackCounters\Pages;

use App\Filament\Resources\CashbackCounters\CashbackCounterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCashbackCounters extends ListRecords
{
    protected static string $resource = CashbackCounterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
