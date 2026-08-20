<?php

namespace App\Filament\Resources\CompanyFunds\Pages;

use App\Filament\Resources\CompanyFunds\CompanyFundResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCompanyFund extends EditRecord
{
    protected static string $resource = CompanyFundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
