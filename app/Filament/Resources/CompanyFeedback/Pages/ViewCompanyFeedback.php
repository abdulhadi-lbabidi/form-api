<?php

namespace App\Filament\Resources\CompanyFeedback\Pages;

use App\Filament\Resources\CompanyFeedback\CompanyFeedbackResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewCompanyFeedback extends ViewRecord
{
  protected static string $resource = CompanyFeedbackResource::class;

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
