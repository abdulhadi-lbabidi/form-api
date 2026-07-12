<?php

namespace App\Filament\Imports;

use App\Models\Company;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class CompanyImporter extends Importer
{
  protected static ?string $model = Company::class;

  public static function getColumns(): array
  {
    return [
      ImportColumn::make('company_name')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
      ImportColumn::make('business_type')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
      ImportColumn::make('owner_name')
        ->rules(['nullable', 'max:255']),
      ImportColumn::make('contact_person_name')
        ->rules(['nullable', 'max:255']),
      ImportColumn::make('code')
        ->rules(['max:255']),
      ImportColumn::make('city')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
      ImportColumn::make('is_verified')
        ->boolean()
        ->rules(['boolean']),
      ImportColumn::make('problems_faced'),
      ImportColumn::make('form_referral_code')
        ->rules(['max:255']),
      ImportColumn::make('work_location')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
      ImportColumn::make('email')
        ->castStateUsing(fn($state) => blank($state) ? null : $state)

        ->rules(['nullable', 'email', 'max:255']),
      ImportColumn::make('phone_number')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
    ];
  }

  public function resolveRecord(): Company
  {
    // return new Company();
    return Company::firstOrNew([
      'phone_number' => $this->data['phone_number'],
    ]);
  }

  public static function getCompletedNotificationBody(Import $import): string
  {
    $body = 'Your company import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

    if ($failedRowsCount = $import->getFailedRowsCount()) {
      $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
    }

    return $body;
  }
}
