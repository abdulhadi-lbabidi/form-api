<?php

namespace App\Filament\Resources\CashbackDeals\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackDealInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل عرض الإعلان')
          ->description('عرض كافة تفاصيل العرض المسجل في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('title')
                ->label('عنوان العرض')
                ->weight('bold')
                ->color('primary')
                ->icon('heroicon-m-tag')
                ->columnSpanFull(),

              TextEntry::make('redirect_url')
                ->label('رابط التوجيه')
                ->url(fn($record) => $record->redirect_url, true)
                ->color('primary')
                ->placeholder('لا يوجد رابط')
                ->icon('heroicon-m-link')
                ->columnSpanFull(),

              TextEntry::make('cashback.company_name')
                ->label('الإعلان الترويجي')
                ->badge()
                ->color('info')
                ->icon('heroicon-m-megaphone'),


              TextEntry::make('status')
                ->label('حالة العرض')
                ->badge()
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'active'   => 'نشط',
                  'inactive' => 'غير نشط',
                  'expired'  => 'منتهي',
                  default    => $state,
                })
                ->color(fn(string $state): string => match ($state) {
                  'active'   => 'success',
                  'inactive' => 'warning',
                  'expired'  => 'danger',
                  default    => 'gray',
                })
                ->icon('heroicon-m-check-badge'),

              TextEntry::make('is_favorite')
                ->label('المفضلة')
                ->formatStateUsing(fn(bool $state): string => $state ? 'نعم (مفضلة)' : 'لا')
                ->badge()
                ->color(fn(bool $state): string => $state ? 'success' : 'gray')
                ->icon(fn(bool $state): string => $state ? 'heroicon-m-star' : 'heroicon-m-minus'),

              TextEntry::make('comosion')
                ->label('العمولة')
                ->formatStateUsing(fn($state) => number_format((float) $state, 2))
                ->weight('bold')
                ->color('success')
                ->icon('heroicon-m-receipt-percent'),

              TextEntry::make('start_date')
                ->label('تاريخ البداية')
                ->date('Y-m-d')
                ->icon('heroicon-m-calendar'),

              TextEntry::make('end_date')
                ->label('تاريخ النهاية')
                ->date('Y-m-d')
                ->icon('heroicon-m-calendar-days'),

              SpatieMediaLibraryImageEntry::make('images_content_deals')
                ->label('صورة البوستر')
                ->collection('cashback-deals')
                ->columnSpanFull(),

              TextEntry::make('content')
                ->label('المحتوى / التفاصيل')
                ->html()
                ->placeholder('لا يوجد محتوى')
                ->columnSpanFull()
                ->icon('heroicon-m-document-text'),

              TextEntry::make('created_at')
                ->label('تاريخ ووقت الإضافة')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-clock')
                ->columnSpanFull()
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
