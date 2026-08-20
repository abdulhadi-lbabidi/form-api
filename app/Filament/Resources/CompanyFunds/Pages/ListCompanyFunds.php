<?php

namespace App\Filament\Resources\CompanyFunds\Pages;

use App\Filament\Resources\CompanyFunds\CompanyFundResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyFunds extends ListRecords
{
    protected static string $resource = CompanyFundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
