<?php

namespace App\Filament\Resources\Kadrs\Pages;

use App\Filament\Resources\Kadrs\KadrResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditKadr extends EditRecord
{
  protected static string $resource = KadrResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(fn() => session()->get('kadrs_previous_url', $this->getResource()::getUrl('index'))),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return session()->get('kadrs_previous_url', $this->getResource()::getUrl('index'));
  }
}
