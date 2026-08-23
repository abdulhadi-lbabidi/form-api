<?php

namespace App\Filament\Resources\CashbackCategories\Pages;

use App\Filament\Resources\CashbackCategories\CashbackCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditCashbackCategory extends EditRecord
{
  protected static string $resource = CashbackCategoryResource::class;

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
