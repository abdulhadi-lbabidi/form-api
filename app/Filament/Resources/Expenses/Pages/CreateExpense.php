<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use App\Models\CompanyFund;
use App\Models\Fund;
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
    $data['fundable_type'] = ($data['fund_type'] === 'company') ? CompanyFund::class : Fund::class;
    $data['fundable_id'] = $data['fund_id'];

    $data['created_by'] = auth()->id();

    unset($data['fund_type'], $data['fund_id']);

    return $data;
  }
}
