<?php

namespace App\Filament\Resources\Workers\Pages;

use App\Filament\Resources\Workers\WorkerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditWorker extends EditRecord
{
  protected static string $resource = WorkerResource::class;

  // public function mount($record): void
  // {
  //   parent::mount($record);
  //   if (str_contains(url()->previous(), 'workers')) {
  //     session()->put('workers_previous_url', url()->previous());
  //   }
  // }

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(fn() => session()->get('workers_previous_url', $this->getResource()::getUrl('index'))),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return session()->get('workers_previous_url', $this->getResource()::getUrl('index'));
  }
}
