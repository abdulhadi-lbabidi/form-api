<?php

namespace App\Filament\Resources\Locations\Pages;

use App\Filament\Resources\Locations\LocationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditLocation extends EditRecord
{
  protected static string $resource = LocationResource::class;

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
