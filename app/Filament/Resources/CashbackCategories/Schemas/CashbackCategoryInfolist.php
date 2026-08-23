<?php

namespace App\Filament\Resources\CashbackCategories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackCategoryInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل التصنيف')
          ->description('عرض كافة تفاصيل التصنيف المسجل في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('name')
                ->label('اسم التصنيف')
                ->weight('bold')
                ->color('primary')
                ->icon('heroicon-m-tag'),

              TextEntry::make('created_at')
                ->label('تاريخ ووقت الإضافة')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-calendar')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

              TextEntry::make('description')
                ->label('الوصف')
                ->placeholder('لا يوجد وصف')
                ->columnSpanFull()
                ->icon('heroicon-m-document-text'),

              TextEntry::make('cashbacks.company_name')
                ->label('الإعلانات التابعة لهذا التصنيف')
                ->badge()
                ->color('success')
                ->placeholder('لا توجد إعلانات مرتبطة بهذا التصنيف')
                ->columnSpanFull()
                ->icon('heroicon-m-building-office'),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
