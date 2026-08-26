<?php

namespace App\Filament\Resources\CashbackCounters\Pages;

use App\Filament\Resources\CashbackCounters\CashbackCounterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCashbackCounter extends ViewRecord
{
  protected static string $resource = CashbackCounterResource::class;
  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      EditAction::make(),
    ];
  }
}
