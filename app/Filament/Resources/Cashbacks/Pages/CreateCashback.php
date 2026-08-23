<?php

namespace App\Filament\Resources\Cashbacks\Pages;

use App\Filament\Resources\Cashbacks\CashbackResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateCashback extends CreateRecord
{
  protected static string $resource = CashbackResource::class;

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