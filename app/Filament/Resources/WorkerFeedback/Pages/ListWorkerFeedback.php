<?php

namespace App\Filament\Resources\WorkerFeedback\Pages;

use App\Filament\Resources\WorkerFeedback\WorkerFeedbackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkerFeedback extends ListRecords
{
    protected static string $resource = WorkerFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
