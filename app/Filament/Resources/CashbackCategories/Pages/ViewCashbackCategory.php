<?php

namespace App\Filament\Resources\CashbackCategories\Pages;

use App\Filament\Resources\CashbackCategories\CashbackCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewCashbackCategory extends ViewRecord
{
  protected static string $resource = CashbackCategoryResource::class;

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
