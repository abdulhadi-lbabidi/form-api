<?php

namespace App\Filament\Resources\KadrFeedback\Pages;

use App\Filament\Resources\KadrFeedback\KadrFeedbackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKadrFeedback extends ListRecords
{
    protected static string $resource = KadrFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
