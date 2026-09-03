<?php

namespace App\Filament\Resources\Kadrs\Pages;

use App\Filament\Resources\Kadrs\KadrResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewKadr extends ViewRecord
{
  protected static string $resource = KadrResource::class;

  public function mount($record): void
  {
    parent::mount($record);

    if (str_contains(url()->previous(), 'kadrs')) {
      session()->put('kadrs_previous_url', url()->previous());
    }
  }


  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(fn() => session()->get('kadrs_previous_url', $this->getResource()::getUrl('index'))),
      EditAction::make(),
    ];
  }
}
