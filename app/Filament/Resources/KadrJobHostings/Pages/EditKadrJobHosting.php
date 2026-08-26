<?php

namespace App\Filament\Resources\KadrJobHostings\Pages;

use App\Filament\Resources\KadrJobHostings\KadrJobHostingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditKadrJobHosting extends EditRecord
{
  protected static string $resource = KadrJobHostingResource::class;

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
