<?php

namespace App\Filament\Resources\Funds\Pages;

use App\Filament\Resources\Funds\FundResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateFund extends CreateRecord
{
  protected static string $resource = FundResource::class;
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
