<?php

namespace App\Filament\Resources\CompanyFeedback\Pages;

use App\Filament\Resources\CompanyFeedback\CompanyFeedbackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyFeedback extends ListRecords
{
    protected static string $resource = CompanyFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
