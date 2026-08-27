<?php

namespace App\Filament\Resources\AccountUpgradeRequests\Pages;

use App\Filament\Resources\AccountUpgradeRequests\AccountUpgradeRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewAccountUpgradeRequest extends ViewRecord
{
  protected static string $resource = AccountUpgradeRequestResource::class;

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
