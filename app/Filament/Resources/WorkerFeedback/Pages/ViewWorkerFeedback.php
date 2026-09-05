<?php

namespace App\Filament\Resources\WorkerFeedback\Pages;

use App\Filament\Resources\WorkerFeedback\WorkerFeedbackResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewWorkerFeedback extends ViewRecord
{
  protected static string $resource = WorkerFeedbackResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      EditAction::make(),
    ];
  }
}
