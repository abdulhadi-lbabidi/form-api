<?php

namespace App\Filament\Resources\KadrFeedback\Pages;

use App\Filament\Resources\KadrFeedback\KadrFeedbackResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditKadrFeedback extends EditRecord
{
  protected static string $resource = KadrFeedbackResource::class;

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
