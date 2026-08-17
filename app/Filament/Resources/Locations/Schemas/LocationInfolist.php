<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ViewEntry;

class LocationInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل المنطقة الجغرافية')
          ->icon('heroicon-o-map')
          ->description('معلومات وإحداثيات المنطقة المسجلة.')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('name')
                ->label('اسم المنطقة')
                ->weight('bold')
                ->color('primary')
                ->icon('heroicon-m-map-pin'),

              TextEntry::make('created_at')
                ->label('تاريخ الإضافة')
                ->dateTime('Y-m-d H:i')
                ->color('gray')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),

            // إضافة خريطة تفاعلية لعرض الحدود أو النقاط
            ViewEntry::make('map')
              ->label('خريطة المنطقة')
              ->view('filament.resources.locations.infolists.map')
              ->columnSpanFull(),

            TextEntry::make('coordinates')
              ->label('الإحداثيات (JSON)')
              ->fontFamily('mono')
              ->badge()
              ->color('success')
              ->formatStateUsing(fn($state) => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
