<?php

namespace App\Filament\Resources\CompanyFeedback\Pages;

use App\Filament\Resources\CompanyFeedback\CompanyFeedbackResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateCompanyFeedback extends CreateRecord
{
  protected static string $resource = CompanyFeedbackResource::class;
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
