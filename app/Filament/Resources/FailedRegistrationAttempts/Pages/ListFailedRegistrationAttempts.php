<?php

namespace App\Filament\Resources\FailedRegistrationAttempts\Pages;

use App\Filament\Resources\FailedRegistrationAttempts\FailedRegistrationAttemptResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFailedRegistrationAttempts extends ListRecords
{
  protected static string $resource = FailedRegistrationAttemptResource::class;

  protected function getHeaderActions(): array
  {
    return [
      // CreateAction::make(),
    ];
  }
}
