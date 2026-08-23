<?php

namespace App\Filament\Resources\CashbackCategories\Pages;

use App\Filament\Resources\CashbackCategories\CashbackCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCashbackCategories extends ListRecords
{
    protected static string $resource = CashbackCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
