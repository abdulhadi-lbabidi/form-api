<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Exports\CompanyExporter;
use App\Filament\Imports\CompanyImporter;
use App\Filament\Resources\Companies\CompanyResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanies extends ListRecords
{
  protected static string $resource = CompanyResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make(),
      ExportAction::make()
        ->exporter(CompanyExporter::class)
        ->label('تصدير إلى Excel')
        ->color('success')
        ->icon('heroicon-m-arrow-down-tray'),

      ImportAction::make()
        ->importer(CompanyImporter::class)
        ->label('استيراد من Excel')
        ->color('info')
        ->icon('heroicon-m-arrow-up-tray'),
    ];
  }
}
