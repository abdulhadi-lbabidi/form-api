<?php

namespace App\Filament\Resources\Currencies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CurrencyInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل العملة')
          ->description('عرض معلومات العملة المسجلة في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('name')
                ->label('اسم العملة')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('symbol')
                ->label('رمز العملة')
                ->badge()
                ->color('success'),

              TextEntry::make('created_at')
                ->label('تاريخ الإضافة')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-calendar')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
