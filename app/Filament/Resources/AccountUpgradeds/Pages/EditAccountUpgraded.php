<?php

namespace App\Filament\Resources\AccountUpgradeds\Pages;

use App\Filament\Resources\AccountUpgradeds\AccountUpgradedResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditAccountUpgraded extends EditRecord
{
  protected static string $resource = AccountUpgradedResource::class;

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
