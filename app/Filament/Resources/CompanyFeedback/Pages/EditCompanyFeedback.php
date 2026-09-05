<?php

namespace App\Filament\Resources\CompanyFeedback\Pages;

use App\Filament\Resources\CompanyFeedback\CompanyFeedbackResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditCompanyFeedback extends EditRecord
{
  protected static string $resource = CompanyFeedbackResource::class;

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
