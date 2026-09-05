<?php

namespace App\Filament\Resources\WorkerFeedback\Pages;

use App\Filament\Resources\WorkerFeedback\WorkerFeedbackResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditWorkerFeedback extends EditRecord
{
  protected static string $resource = WorkerFeedbackResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }
}
