<?php

namespace App\Filament\Resources\Times\Pages;

use App\Filament\Resources\Times\TimeResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateTime extends CreateRecord
{
  protected static string $resource = TimeResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}