<?php

namespace App\Filament\Resources\AdminBookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminBookingInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الحجز الإداري')
          ->description('معلومات تفصيلية عن الحجز الإداري والجهات والأشخاص المرتبطين به.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('user.name')
                ->label('المسؤول عن الحجز')
                ->icon('heroicon-m-user')
                ->weight('bold'),

              TextEntry::make('interviewer.name')
                ->label('المقابل')
                ->weight('bold')
                ->color('success')
                ->placeholder('غير محدد'),

              TextEntry::make('status')
                ->label('حالة الحجز')
                ->color(fn(string $state): string => match ($state) {
                  'pending' => 'warning',
                  'active' => 'info',
                  'completed' => 'success',
                  'canceled' => 'danger',
                  default => 'gray',
                })
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'pending' => 'قيد الانتظار',
                  'active' => 'نشط',
                  'completed' => 'تمت المقابلة',
                  'canceled' => 'ملغي',
                  default => $state,
                }),

              TextEntry::make('booking_date')
                ->label('تاريخ الحجز')
                ->date('Y-m-d')
                ->weight('bold')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

              TextEntry::make('time_from')
                ->label('من الساعة')
                ->icon('heroicon-m-clock')
                ->time('H:i')
                ->weight('bold'),

              TextEntry::make('time_to')
                ->label('إلى الساعة')
                ->icon('heroicon-m-clock')
                ->time('H:i')
                ->weight('bold'),

              TextEntry::make('companies.company_name')
                ->label('الشركات المرتبطة')
                ->separator(',')
                ->placeholder('لا يوجد شركات مرتبطة'),

              TextEntry::make('workers.full_name')
                ->label('العمال المرتبطون')
                ->separator(',')
                ->placeholder('لا يوجد عمال مرتبطون'),
            ]),

            TextEntry::make('notes')
              ->label('الملاحظات الإضافية')
              ->placeholder('لا توجد ملاحظات مسجلة لهذا الحجز حالياً.')
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
