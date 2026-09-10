<?php

namespace App\Filament\Resources\FailedRegistrationAttempts\Pages;

use App\Filament\Resources\FailedRegistrationAttempts\FailedRegistrationAttemptResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateFailedRegistrationAttempt extends CreateRecord
{
  protected static string $resource = FailedRegistrationAttemptResource::class;
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
