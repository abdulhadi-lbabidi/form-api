<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubscriptionInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل سجل الاشتراك')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('time.work_time')
                ->label('الفترة الزمنية')
                ->icon('heroicon-m-clock')
                ->weight('bold'),

              TextEntry::make('status')
                ->label('حالة الاشتراك'),
            ]),

            TextEntry::make('note')
              ->label('الملاحظات')
              ->placeholder('لا توجد ملاحظات مسجلة')
              ->columnSpanFull(),
          ])->columnSpanFull(),

        Section::make('التواريخ والنظام')
          ->icon('heroicon-o-clock')
          ->compact()
          ->columns(2)
          ->schema([
            TextEntry::make('created_at')
              ->label('تاريخ الإنشاء')
              ->dateTime('Y-m-d H:i A'),

            TextEntry::make('updated_at')
              ->label('آخر تحديث')
              ->dateTime('Y-m-d H:i A'),
          ])->columnSpanFull(),
      ]);
  }
}
