<?php

namespace App\Filament\Resources\KadrNeeds\Pages;

use App\Filament\Resources\KadrNeeds\KadrNeedResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditKadrNeed extends EditRecord
{
  protected static string $resource = KadrNeedResource::class;

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
