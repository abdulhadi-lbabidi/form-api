<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCompany extends ViewRecord
{
  protected static string $resource = CompanyResource::class;

  // protected function getHeaderActions(): array
  // {
  //   return [
  //     Actions\Action::make('back')
  //       ->label('رجوع')
  //       ->color('gray')
  //       ->url($this->getResource()::getUrl('index')),
  //     EditAction::make(),
  //   ];
  // }

  public function mount($record): void
  {
    parent::mount($record);
    if (request()->has('page') || str_contains(url()->previous(), 'page=')) {
      session()->put('workers_previous_url', url()->previous());
    }
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(fn() => session()->get('workers_previous_url', $this->getResource()::getUrl('index'))),
      EditAction::make(),
    ];
  }
}
