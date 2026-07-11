<?php

namespace App\Filament\Resources\CompanyBranches\Pages;

use App\Filament\Resources\CompanyBranches\CompanyBranchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCompanyBranch extends ViewRecord
{
  protected static string $resource = CompanyBranchResource::class;

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
