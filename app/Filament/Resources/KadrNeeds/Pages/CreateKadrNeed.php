<?php

namespace App\Filament\Resources\KadrNeeds\Pages;

use App\Filament\Resources\KadrNeeds\KadrNeedResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateKadrNeed extends CreateRecord
{
  protected static string $resource = KadrNeedResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }
}
