<?php

namespace App\Filament\Resources\CompanyJobHostings\Pages;

use App\Filament\Resources\CompanyJobHostings\CompanyJobHostingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyJobHostings extends ListRecords
{
    protected static string $resource = CompanyJobHostingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
