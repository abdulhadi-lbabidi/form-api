<?php

namespace App\Filament\Resources\KadrFeedback\Pages;

use App\Filament\Resources\KadrFeedback\KadrFeedbackResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewKadrFeedback extends ViewRecord
{
  protected static string $resource = KadrFeedbackResource::class;

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
