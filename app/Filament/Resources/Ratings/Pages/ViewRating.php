<?php

namespace App\Filament\Resources\Ratings\Pages;

use App\Filament\Resources\Ratings\RatingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewRating extends ViewRecord
{
  protected static string $resource = RatingResource::class;

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
