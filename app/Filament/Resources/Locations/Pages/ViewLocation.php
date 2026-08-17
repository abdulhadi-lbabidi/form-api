<?php

namespace App\Filament\Resources\Locations\Pages;

use App\Filament\Resources\Locations\LocationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewLocation extends ViewRecord
{
  protected static string $resource = LocationResource::class;

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
