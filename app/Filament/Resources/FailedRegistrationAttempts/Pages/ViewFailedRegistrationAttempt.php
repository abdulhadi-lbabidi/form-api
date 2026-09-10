<?php

namespace App\Filament\Resources\FailedRegistrationAttempts\Pages;

use App\Filament\Resources\FailedRegistrationAttempts\FailedRegistrationAttemptResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewFailedRegistrationAttempt extends ViewRecord
{
  protected static string $resource = FailedRegistrationAttemptResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      // EditAction::make(),
    ];
  }
}
