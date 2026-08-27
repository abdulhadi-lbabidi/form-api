<?php

namespace App\Filament\Resources\AccountUpgradeds\Pages;

use App\Filament\Resources\AccountUpgradeds\AccountUpgradedResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewAccountUpgraded extends ViewRecord
{
  protected static string $resource = AccountUpgradedResource::class;

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
