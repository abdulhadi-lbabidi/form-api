<?php

namespace App\Filament\Resources\CompanyNeeds\Pages;

use App\Filament\Resources\CompanyNeeds\CompanyNeedResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateCompanyNeed extends CreateRecord
{
  protected static string $resource = CompanyNeedResource::class;
  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
