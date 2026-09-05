<?php

namespace App\Filament\Resources\WorkerFeedback\Pages;

use App\Filament\Resources\WorkerFeedback\WorkerFeedbackResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateWorkerFeedback extends CreateRecord
{
  protected static string $resource = WorkerFeedbackResource::class;
  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }
}
