<?php

namespace App\Filament\Resources\Workers\Pages;

use App\Filament\Exports\WorkerExporter;
use App\Filament\Imports\WorkerImporter;
use App\Filament\Resources\Workers\WorkerResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkers extends ListRecords
{
  protected static string $resource = WorkerResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make(),

      ExportAction::make()
        ->exporter(WorkerExporter::class)
        ->label('تصدير إلى Excel')
        ->color('success')
        ->icon('heroicon-m-arrow-down-tray'),

      ImportAction::make()
        ->importer(WorkerImporter::class)
        ->label('استيراد من Excel')
        ->color('info')
        ->icon('heroicon-m-arrow-up-tray'),
    ];
  }
}
