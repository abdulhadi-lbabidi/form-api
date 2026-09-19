<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Exports\CompanyExporter;
use App\Filament\Imports\CompanyImporter;
use App\Filament\Resources\Companies\CompanyResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListCompanies extends ListRecords
{
  protected static string $resource = CompanyResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make(),
      // ExportAction::make()
      //   ->exporter(CompanyExporter::class)
      //   ->label('تصدير إلى Excel')
      //   ->color('success')
      //   ->icon('heroicon-m-arrow-down-tray')
      //   ->visible(fn() => auth()->user()->hasRole('super_admin') || auth()->user()->can('export_company')),

      // ImportAction::make()
      //   ->importer(CompanyImporter::class)
      //   ->label('استيراد من Excel')
      //   ->color('info')
      //   ->icon('heroicon-m-arrow-up-tray')
      //   ->visible(fn() => auth()->user()->hasRole('super_admin') || auth()->user()->can('import_company')),
    ];
  }

  public function getTabs(): array
  {
    $user = Auth::user();

    // إذا لم يكن مندوباً (أدمن أو مشرف)، لا نحتاج لتقسيم التبويبات لديه
    if (!$user || !$user->hasRole('delegate')) {
      return [];
    }

    return [
      'my_companies' => Tab::make('شركاتي المضافة')
        ->icon('heroicon-m-building-office')
        // تم استخدام added_by بدلاً من created_by ليتطابق مع جدول الشركات لديك
        ->modifyQueryUsing(fn(Builder $query) => $query->where('added_by', $user->id)),

      'all_companies_lookup' => Tab::make('البحث في كافة الشركات (أسماء فقط)')
        ->icon('heroicon-m-magnifying-glass')
        ->modifyQueryUsing(fn(Builder $query) => $query),
    ];
  }
}