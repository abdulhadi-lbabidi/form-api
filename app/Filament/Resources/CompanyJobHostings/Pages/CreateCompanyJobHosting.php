<?php

namespace App\Filament\Resources\CompanyJobHostings\Pages;

use App\Filament\Resources\CompanyJobHostings\CompanyJobHostingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateCompanyJobHosting extends CreateRecord
{
  protected static string $resource = CompanyJobHostingResource::class;

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
