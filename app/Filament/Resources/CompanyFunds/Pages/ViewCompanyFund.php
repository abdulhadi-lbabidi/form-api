<?php

namespace App\Filament\Resources\CompanyFunds\Pages;

use App\Filament\Resources\CompanyFunds\CompanyFundResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCompanyFund extends ViewRecord
{
    protected static string $resource = CompanyFundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
