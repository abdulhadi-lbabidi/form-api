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
          ->description('معلومات الفترة الزمنية المحجوزة وحالة تفعيل الاشتراك الحالية.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('time.work_time')
                ->label('الفترة الزمنية')
                ->icon('heroicon-m-clock')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('status')
                ->label('حالة الاشتراك')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                  'active' => 'success',
                  'pending' => 'warning',
                  'canceled' => 'danger',
                  default => 'gray',
                })
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'pending' => 'قيد الانتظار',
                  'active' => 'نشط',
                  'canceled' => 'ملغي',
                  default => $state,
                }),
            ]),

            TextEntry::make('note')
              ->label('الملاحظات الإضافية')
              ->placeholder('لا توجد ملاحظات مسجلة لهذا الاشتراك حالياً.')
              ->columnSpanFull(),
          ])->columnSpanFull(),

        Section::make('التواريخ والنظام')
          ->icon('heroicon-o-clock')
          ->compact()
          ->columns(2)
          ->schema([
            TextEntry::make('created_at')
              ->label('تاريخ الإنشاء')
              ->icon('heroicon-m-calendar')
              ->dateTime('Y-m-d H:i A')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: sans-serif;']),


          ])->columnSpanFull(),
      ]);
  }
}
