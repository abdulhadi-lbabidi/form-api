<?php

namespace App\Filament\Resources\CompanyJobHostings\Pages;

use App\Filament\Resources\CompanyJobHostings\CompanyJobHostingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewCompanyJobHosting extends ViewRecord
{
  protected static string $resource = CompanyJobHostingResource::class;

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
