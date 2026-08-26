<?php

namespace App\Filament\Resources\CashbackCounters\Pages;

use App\Filament\Resources\CashbackCounters\CashbackCounterResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateCashbackCounter extends CreateRecord
{
  protected static string $resource = CashbackCounterResource::class;
  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }
}
