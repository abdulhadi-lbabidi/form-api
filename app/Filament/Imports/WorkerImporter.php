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
        ->rules(['max:255']),

      ImportColumn::make('form_referral_code')
        ->rules(['max:255']),

      ImportColumn::make('first_name')

        ->rules(['max:255']),
      ImportColumn::make('last_name')

        ->rules(['max:255']),
      ImportColumn::make('father_name')

        ->rules(['max:255']),
      ImportColumn::make('full_name')
        ->rules(['max:255']),

      ImportColumn::make('mother_fullname')
        ->rules(['max:255']),

      ImportColumn::make('phone_whatsapp')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
      ImportColumn::make('age')
        ->requiredMapping(),

      ImportColumn::make('city')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
      ImportColumn::make('residential_area')
        ->requiredMapping()
        ->rules(['required', 'max:255']),

      ImportColumn::make('marital_status')
        ->requiredMapping()
        ->rules(['required', 'max:255']),

      ImportColumn::make('is_verified')
        ->boolean()
        ->rules(['boolean']),

      ImportColumn::make('primary_profession')
        ->requiredMapping()
        ->rules(['required', 'max:255']),
      ImportColumn::make('other_professions'),

      ImportColumn::make('work_hours')
        ->requiredMapping()
        ->rules(['required', 'max:255']),

      ImportColumn::make('commitment_level')
        ->requiredMapping()
        ->rules(['required', 'max:255']),

      ImportColumn::make('working_status')
        ->rules(['max:255']),
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
