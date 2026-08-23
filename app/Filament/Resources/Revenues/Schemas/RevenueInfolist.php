<?php

namespace App\Filament\Resources\Revenues\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RevenueInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الإيراد')
          ->description('عرض كافة تفاصيل الإيراد المسجل في النظام.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('name')
                ->label('اسم الإيراد / البيان')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('amount')
                ->label('المبلغ')
                ->formatStateUsing(fn($state) => number_format((float) $state, 2, '.', ''))
                ->weight('bold')
                ->color('success')
                ->extraAttributes(['style' => 'direction: ltr; text-align: right;']),

              TextEntry::make('fundable.name')
                ->label('الصندوق')
                ->badge()
                ->color('info')
                ->icon('heroicon-m-wallet'),

              TextEntry::make('currency.name')
                ->label('العملة')
                ->badge()
                ->color('warning')
                ->icon('heroicon-m-currency-dollar'),

              TextEntry::make('creator.name')
                ->label('أُضيف بواسطة')
                ->placeholder('النظام')
                ->icon('heroicon-m-user'),

              TextEntry::make('created_at')
                ->label('تاريخ ووقت الإضافة')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-calendar')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

              TextEntry::make('description')
                ->label('ملاحظات / الوصف')
                ->placeholder('لا توجد ملاحظات')
                ->columnSpanFull()
                ->icon('heroicon-m-document-text'),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
