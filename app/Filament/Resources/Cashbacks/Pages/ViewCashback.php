<?php

namespace App\Filament\Resources\Cashbacks\Pages;

use App\Filament\Resources\Cashbacks\CashbackResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCashback extends ViewRecord
{
  protected static string $resource = CashbackResource::class;

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
