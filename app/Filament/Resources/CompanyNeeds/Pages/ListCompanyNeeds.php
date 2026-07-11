<?php

namespace App\Filament\Resources\CompanyNeeds\Pages;

use App\Filament\Resources\CompanyNeeds\CompanyNeedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyNeeds extends ListRecords
{
    protected static string $resource = CompanyNeedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
