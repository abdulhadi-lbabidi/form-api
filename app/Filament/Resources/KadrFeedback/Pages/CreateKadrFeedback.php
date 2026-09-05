<?php

namespace App\Filament\Resources\KadrFeedback\Pages;

use App\Filament\Resources\KadrFeedback\KadrFeedbackResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateKadrFeedback extends CreateRecord
{
  protected static string $resource = KadrFeedbackResource::class;
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
