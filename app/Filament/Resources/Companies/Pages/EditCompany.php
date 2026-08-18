<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditCompany extends EditRecord
{
  protected static string $resource = CompanyResource::class;

  public function mount($record): void
  {
    parent::mount($record);
    if (!session()->has('companies_previous_url')) {
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
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return session()->get('companies_previous_url', $this->getResource()::getUrl('index'));
  }
}
