<?php

namespace App\Filament\Resources\Funds\Pages;

use App\Filament\Resources\Funds\FundResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewFund extends ViewRecord
{
  protected static string $resource = FundResource::class;

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
