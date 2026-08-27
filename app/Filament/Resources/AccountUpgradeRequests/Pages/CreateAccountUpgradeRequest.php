<?php

namespace App\Filament\Resources\AccountUpgradeRequests\Pages;

use App\Filament\Resources\AccountUpgradeRequests\AccountUpgradeRequestResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateAccountUpgradeRequest extends CreateRecord
{
  protected static string $resource = AccountUpgradeRequestResource::class;
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
