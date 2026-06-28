<?php

namespace App\Filament\Resources\ReferralCodes\Pages;

use App\Filament\Resources\ReferralCodes\ReferralCodeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewReferralCode extends ViewRecord
{
  protected static string $resource = ReferralCodeResource::class;

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
