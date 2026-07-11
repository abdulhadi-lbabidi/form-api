<?php

namespace App\Filament\Resources\CompanyBranches\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyBranchInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل سجل فرع الشركة')
          ->description('بيانات الفرع والارتباط بالشركة الأم.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([

              TextEntry::make('company.company_name')
                ->label('الشركة الأم')
                ->icon('heroicon-m-building-office-2')
                ->color('primary')
                ->weight('bold'),

              TextEntry::make('branch_name')
                ->label('اسم الفرع')
                ->icon('heroicon-m-building-office')
                ->weight('bold'),

              TextEntry::make('location_address')
                ->label('الموقع التفصيلي للفرع')
                ->icon('heroicon-m-map-pin')
                ->placeholder('لم يتم تحديد عنوان تفصيلي')
                ->columnSpanFull(),

              TextEntry::make('created_at')
                ->label('تاريخ تسجيل الفرع')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
