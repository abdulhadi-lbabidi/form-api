<?php

namespace App\Filament\Resources\CompanyJobHostings\Pages;

use App\Filament\Resources\CompanyJobHostings\CompanyJobHostingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditCompanyJobHosting extends EditRecord
{
  protected static string $resource = CompanyJobHostingResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }
}
