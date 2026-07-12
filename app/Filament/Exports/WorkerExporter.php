<?php

namespace App\Filament\Exports;

use App\Models\Worker;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class WorkerExporter extends Exporter
{
  protected static ?string $model = Worker::class;

  public static function getColumns(): array
  {
    return [
      ExportColumn::make('id')
        ->label('ID'),
      ExportColumn::make('code'),
      ExportColumn::make('form_referral_code'),
      ExportColumn::make('first_name'),
      ExportColumn::make('last_name'),
      ExportColumn::make('father_name'),
      ExportColumn::make('full_name'),
      ExportColumn::make('mother_fullname'),
      ExportColumn::make('phone_whatsapp'),
      ExportColumn::make('age'),
      ExportColumn::make('city'),
      ExportColumn::make('residential_area'),
      ExportColumn::make('marital_status'),
      ExportColumn::make('is_verified'),
      ExportColumn::make('primary_profession'),
      ExportColumn::make('other_professions'),
      ExportColumn::make('work_hours'),
      ExportColumn::make('commitment_level'),
      ExportColumn::make('working_status'),
      ExportColumn::make('expected_hourly_rate_usd'),
      ExportColumn::make('expected_hourly_rate_syp'),
      ExportColumn::make('payment_method'),
      ExportColumn::make('created_at'),
      ExportColumn::make('updated_at'),
    ];
  }

  public static function getCompletedNotificationBody(Export $export): string
  {
    $body = 'Your worker export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

    if ($failedRowsCount = $export->getFailedRowsCount()) {
      $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
    }

    return $body;
  }
}
