<?php

namespace App\Filament\Resources\Kadrs\Pages;

use App\Filament\Resources\Kadrs\KadrResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewKadr extends ViewRecord
{
  protected static string $resource = KadrResource::class;

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
