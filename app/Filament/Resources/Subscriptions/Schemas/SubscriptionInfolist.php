<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Models\Company;
use App\Models\Worker;
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
            Grid::make(3)->schema([

              TextEntry::make('subscribable')
                ->label('المشترك')
                ->icon(fn($record) => $record?->subscribable_type === Company::class ? 'heroicon-m-building-office' : 'heroicon-m-user')
                ->weight('bold')
                ->state(function ($record) {
                  if (!$record || !$record->subscribable) return '—';

                  if ($record->subscribable_type === Company::class) {
                    return "شركة: " . $record->subscribable->company_name;
                  }

                  if ($record->subscribable_type === Worker::class) {
                    return "عامل: " . $record->subscribable->first_name . ' ' . $record->subscribable->last_name;
                  }

                  return '—';
                }),

              TextEntry::make('date')
                ->label('تاريخ الحجز')
                ->icon('heroicon-m-calendar-days')
                ->date('Y-m-d')
                ->weight('bold')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),


              TextEntry::make('time.work_time')
                ->label('الفترة الزمنية')
                ->icon('heroicon-m-clock')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('status')
                ->label('حالة الاشتراك')
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

              TextEntry::make('phone_number')
                ->label('رقم الهاتف')
                ->placeholder('لا يوجد رقم هاتف مسجل')
                ->weight('bold'),

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
