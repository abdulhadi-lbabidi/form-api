<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use App\Models\CompanyFund;
use App\Models\Fund;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditExpense extends EditRecord
{
  protected static string $resource = ExpenseResource::class;

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

  protected function mutateFormDataBeforeFill(array $data): array
  {
    if (isset($data['fundable_type'])) {
      $data['fund_type'] = ($data['fundable_type'] === CompanyFund::class) ? 'company' : 'user';
      $data['fund_id'] = $data['fundable_id'];
    }

    return $data;
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['fundable_type'] = ($data['fund_type'] === 'company') ? CompanyFund::class : Fund::class;
    $data['fundable_id'] = $data['fund_id'];

    unset($data['fund_type'], $data['fund_id']);

    return $data;
  }
}
