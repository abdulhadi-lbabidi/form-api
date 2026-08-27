<?php

namespace App\Filament\Resources\AccountUpgradeds\Pages;

use App\Filament\Resources\AccountUpgradeds\AccountUpgradedResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateAccountUpgraded extends CreateRecord
{
  protected static string $resource = AccountUpgradedResource::class;
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
