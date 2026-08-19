<?php

namespace App\Filament\Resources\KadrNeeds\Pages;

use App\Filament\Resources\KadrNeeds\KadrNeedResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewKadrNeed extends ViewRecord
{
  protected static string $resource = KadrNeedResource::class;

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
