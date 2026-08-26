<?php

namespace App\Filament\Resources\CashbackCounters\Pages;

use App\Filament\Resources\CashbackCounters\CashbackCounterResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditCashbackCounter extends EditRecord
{
  protected static string $resource = CashbackCounterResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }
}
