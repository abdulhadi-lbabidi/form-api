<?php

namespace App\Filament\Resources\Ratings\Pages;

use App\Filament\Resources\Ratings\RatingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateRating extends CreateRecord
{
  protected static string $resource = RatingResource::class;
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