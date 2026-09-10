<?php

namespace App\Filament\Resources\FailedRegistrationAttempts\Pages;

use App\Filament\Resources\FailedRegistrationAttempts\FailedRegistrationAttemptResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditFailedRegistrationAttempt extends EditRecord
{
  protected static string $resource = FailedRegistrationAttemptResource::class;

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
