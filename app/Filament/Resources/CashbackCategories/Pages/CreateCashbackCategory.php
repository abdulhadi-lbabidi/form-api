<?php

namespace App\Filament\Resources\CashbackCategories\Pages;

use App\Filament\Resources\CashbackCategories\CashbackCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateCashbackCategory extends CreateRecord
{
  protected static string $resource = CashbackCategoryResource::class;
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
