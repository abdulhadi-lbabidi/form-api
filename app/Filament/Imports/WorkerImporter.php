<?php

namespace App\Filament\Imports;

use App\Models\Worker;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class WorkerImporter extends Importer
{
  protected static ?string $model = Worker::class;

  public static function getColumns(): array
  {
    return [
      ImportColumn::make('code')
        ->rules([]),

      ImportColumn::make('form_referral_code')
        ->rules([]),

      ImportColumn::make('first_name')
        ->rules([]),

      ImportColumn::make('last_name')
        ->rules([]),

      ImportColumn::make('father_name')
        ->rules([]),

      ImportColumn::make('full_name')
        ->rules([]),

      ImportColumn::make('mother_fullname')
        ->rules([]),

      ImportColumn::make('phone_whatsapp')
        ->requiredMapping()
        ->rules(['required']),

      ImportColumn::make('age')
        ->requiredMapping()
        ->rules(['required', 'date']),

      ImportColumn::make('city')
        ->requiredMapping()
        ->rules(['required',]),
      ImportColumn::make('residential_area')
        ->requiredMapping()
        ->rules(['required']),

      ImportColumn::make('marital_status')
        ->requiredMapping()
        ->rules(['required']),

      ImportColumn::make('is_verified')
        ->boolean(),

      ImportColumn::make('primary_profession')
        ->requiredMapping()
        ->rules(['required']),
      ImportColumn::make('other_professions'),

      ImportColumn::make('work_hours')
        ->requiredMapping()
        ->rules(['required']),

      ImportColumn::make('commitment_level')
        ->requiredMapping()
        ->rules(['required']),

      ImportColumn::make('working_status')
        ->rules([]),

      ImportColumn::make('expected_hourly_rate_usd')
        ->numeric()
        ->rules(['integer']),

      ImportColumn::make('expected_hourly_rate_syp')
        ->numeric()
        ->rules(['integer']),

      ImportColumn::make('payment_method')
        ->requiredMapping()
        ->rules(['required']),
    ];
  }

  public function resolveRecord(): Worker
  {
    return Worker::firstOrNew([
      'phone_whatsapp' => $this->data['phone_whatsapp'] ?? null,
    ]);
  }

  public static function getCompletedNotificationBody(Import $import): string
  {
    $body = 'Your worker import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

    if ($failedRowsCount = $import->getFailedRowsCount()) {
      $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
    }

    return $body;
  }
}
