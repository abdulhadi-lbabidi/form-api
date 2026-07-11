<?php

namespace App\Filament\Resources\CompanyBranches\Pages;

use App\Filament\Resources\CompanyBranches\CompanyBranchResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateCompanyBranch extends CreateRecord
{
  protected static string $resource = CompanyBranchResource::class;
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
