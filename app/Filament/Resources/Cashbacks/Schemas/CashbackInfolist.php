<?php

namespace App\Filament\Resources\Cashbacks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الإعلان')
          ->description('عرض كافة تفاصيل الإعلان المسجل في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('company_name')
                ->label('اسم الشركة')
                ->weight('bold')
                ->color('primary')
                ->icon('heroicon-m-building-office'),

              TextEntry::make('reasone')
                ->label('السبب')
                ->placeholder('لا يوجد')
                ->icon('heroicon-m-document-text'),

              TextEntry::make('is_favorite')
                ->label('المفضلة')
                ->formatStateUsing(fn(bool $state): string => $state ? 'نعم (مفضلة)' : 'لا')
                ->badge()
                ->color(fn(bool $state): string => $state ? 'success' : 'gray')
                ->icon(fn(bool $state): string => $state ? 'heroicon-m-star' : 'heroicon-m-minus'),

              TextEntry::make('redirect_url')
                ->label('رابط التوجيه')
                ->url(fn($record) => $record->redirect_url, true)
                ->color('primary')
                ->placeholder('لا يوجد رابط')
                ->icon('heroicon-m-link')
                ->columnSpanFull(),

              TextEntry::make('categories.name')
                ->label('التصنيفات')
                ->badge()
                ->color('info')
                ->placeholder('لا توجد تصنيفات')
                ->icon('heroicon-m-tag')
                ->columnSpanFull(),

              TextEntry::make('number_of_clicks')
                ->label('عدد النقرات')
                ->numeric()
                ->badge()
                ->color('success')
                ->icon('heroicon-m-cursor-arrow-rays'),

              TextEntry::make('created_at')
                ->label('تاريخ ووقت الإضافة')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-calendar')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
