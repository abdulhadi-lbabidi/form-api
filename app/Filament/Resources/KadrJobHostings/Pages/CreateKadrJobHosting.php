<?php

namespace App\Filament\Resources\KadrJobHostings\Pages;

use App\Filament\Resources\KadrJobHostings\KadrJobHostingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateKadrJobHosting extends CreateRecord
{
  protected static string $resource = KadrJobHostingResource::class;

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
