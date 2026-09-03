<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCompany extends ViewRecord
{
  protected static string $resource = CompanyResource::class;

  public function mount($record): void
  {
    parent::mount($record);

    if (str_contains(url()->previous(), 'companies')) {
      session()->put('companies_previous_url', url()->previous());
    }
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(fn() => session()->get('companies_previous_url', $this->getResource()::getUrl('index'))),
      EditAction::make(),
    ];
  }
}
