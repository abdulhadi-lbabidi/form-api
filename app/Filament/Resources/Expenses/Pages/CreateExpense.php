<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateExpense extends CreateRecord
{
  protected static string $resource = ExpenseResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['created_by'] = auth()->id();

    return $data;
  }
}
