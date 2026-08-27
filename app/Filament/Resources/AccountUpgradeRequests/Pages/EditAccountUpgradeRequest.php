<?php

namespace App\Filament\Resources\AccountUpgradeRequests\Pages;

use App\Filament\Resources\AccountUpgradeRequests\AccountUpgradeRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditAccountUpgradeRequest extends EditRecord
{
  protected static string $resource = AccountUpgradeRequestResource::class;

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
