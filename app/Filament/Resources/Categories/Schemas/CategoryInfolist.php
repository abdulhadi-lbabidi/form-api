<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات وتفاصيل التصنيف')
          ->icon('heroicon-o-tag')
          ->schema([
            Grid::make(1)->schema([
              TextEntry::make('name')
                ->label('اسم التصنيف')
                ->weight('bold')
                ->size('lg')
                ->color('primary'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('workers_count')
                ->label('العمال التابعون')
                ->state(fn($record) => $record->workers()->count() . ' عامل')
                ->icon('heroicon-m-users')
                ->badge()
                ->color('success'),

              TextEntry::make('kadrs_count')
                ->label('الكوادر التابعون')
                ->state(fn($record) => $record->kadrs()->count() . ' كادر')
                ->icon('heroicon-m-user-group')
                ->badge()
                ->color('info'),

              TextEntry::make('companies_count')
                ->label('الشركات التابعة')
                ->state(fn($record) => $record->companies()->count() . ' شركة')
                ->icon('heroicon-m-building-office-2')
                ->badge()
                ->color('warning'),

              TextEntry::make('company_job_hostings_count')
                ->label('شواغر الشركات')
                ->state(fn($record) => $record->companyJobHostings()->count() . ' شاغر شركة')
                ->icon('heroicon-m-briefcase')
                ->badge()
                ->color('warning'),

              TextEntry::make('compankadr_job_hostings_counties_count')
                ->label('شواغر الكوادر')
                ->state(fn($record) => $record->kadrJobHostings()->count() . ' شاغر كادر')
                ->icon('heroicon-m-briefcase')
                ->badge()
                ->color('warning'),
            ]),

            TextEntry::make('description')
              ->label('الوصف')
              ->placeholder('لا يوجد وصف لهذا التصنيف')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
