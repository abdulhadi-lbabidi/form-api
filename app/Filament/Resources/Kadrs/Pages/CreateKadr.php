<?php

namespace App\Filament\Resources\Kadrs\Pages;

use App\Filament\Resources\Kadrs\KadrResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateKadr extends CreateRecord
{
  protected static string $resource = KadrResource::class;

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
