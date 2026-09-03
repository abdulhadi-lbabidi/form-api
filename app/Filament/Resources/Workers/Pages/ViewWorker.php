<?php

namespace App\Filament\Resources\Workers\Pages;

use App\Filament\Resources\Workers\WorkerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewWorker extends ViewRecord
{
  protected static string $resource = WorkerResource::class;

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
    // if (request()->has('page') || str_contains(url()->previous(), 'page=')) {
    //   session()->put('workers_previous_url', url()->previous());
    // }
    if (str_contains(url()->previous(), 'workers')) {
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
