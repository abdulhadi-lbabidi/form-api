<?php

namespace App\Filament\Exports;

use App\Models\Company;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class CompanyExporter extends Exporter
{
  protected static ?string $model = Company::class;

  public static function getColumns(): array
  {
    return [
      ExportColumn::make('id')
        ->label('ID'),
      ExportColumn::make('company_name'),
      ExportColumn::make('business_type'),
      ExportColumn::make('owner_name'),
      ExportColumn::make('contact_person_name'),
      ExportColumn::make('code'),
      ExportColumn::make('city'),
      ExportColumn::make('is_verified'),
      ExportColumn::make('problems_faced'),
      ExportColumn::make('form_referral_code'),
      ExportColumn::make('work_location'),
      ExportColumn::make('email'),
      ExportColumn::make('phone_number'),
    ];
  }

  public static function getCompletedNotificationBody(Export $export): string
  {
    $body = 'Your company export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

    if ($failedRowsCount = $export->getFailedRowsCount()) {
      $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
    }

    return $body;
  }
}
