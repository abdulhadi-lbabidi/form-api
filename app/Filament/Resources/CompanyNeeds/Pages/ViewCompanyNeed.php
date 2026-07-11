<?php

namespace App\Filament\Resources\CompanyNeeds\Pages;

use App\Filament\Resources\CompanyNeeds\CompanyNeedResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCompanyNeed extends ViewRecord
{
  protected static string $resource = CompanyNeedResource::class;

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
