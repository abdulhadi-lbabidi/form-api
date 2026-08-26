<?php

namespace App\Filament\Resources\KadrJobHostings\Pages;

use App\Filament\Resources\KadrJobHostings\KadrJobHostingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewKadrJobHosting extends ViewRecord
{
  protected static string $resource = KadrJobHostingResource::class;

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
