<?php

namespace App\Filament\Resources\Workers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkerInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('الملف الشخصي للعامل')
          ->icon('heroicon-o-user-circle')
          ->description('البيانات الشخصية الأساسية ومعلومات العائلة.')
          ->schema([
            Grid::make(4)->schema([
              TextEntry::make('first_name')
                ->label('الاسم الأول')
                ->weight('bold'),
              TextEntry::make('last_name')
                ->label('العائلة')
                ->weight('bold'),
              TextEntry::make('father_name')
                ->label('اسم الأب'),
              TextEntry::make('mother_fullname')
                ->label('اسم الأم الكامل'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('age')
                ->label('العمر')
                ->icon('heroicon-m-calendar-days')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family:cairo;']),

              TextEntry::make('marital_status')
                ->label('الحالة الاجتماعية')
                ->badge()
                ->color(fn($state) => match ($state) {
                  'single' => 'info',
                  'married' => 'success',
                  default => 'gray'
                })
                ->formatStateUsing(fn($state) => match ($state) {
                  'single' => 'عازب',
                  'married' => 'متزوج',
                  'other' => 'غير ذلك',
                  default => $state
                }),

              TextEntry::make('phone_whatsapp')
                ->label('رقم الهاتف / واتساب')
                ->icon('heroicon-m-phone')
                ->color('success')
                ->url(fn($record) => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->phone_whatsapp), shouldOpenInNewTab: true)
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; font-weight: bold;']),
            ]),
          ])->columnSpanFull(),

        Section::make('السكن وطبيعة العمل')
          ->icon('heroicon-o-briefcase')
          ->description('تفاصيل مكان الإقامة، والمهن المتاحة، والبيانات المالية.')
          ->columns(3)
          ->schema([
            TextEntry::make('city')
              ->label('المدينة / المحافظة')
              ->icon('heroicon-m-map-pin')
              ->color('primary'),

            TextEntry::make('residential_area')
              ->label('المنطقة / السكن')
              ->icon('heroicon-m-map'),

            TextEntry::make('primary_profession')
              ->label('المهنة الأساسية')
              ->icon('heroicon-m-briefcase')
              ->weight('bold'),

            TextEntry::make('work_hours')
              ->label('ساعات العمل المتاحة')
              ->icon('heroicon-m-clock'),

            TextEntry::make('commitment_level')
              ->label('مستوى الالتزام')
              ->badge()
              ->color('gray'),

            TextEntry::make('expected_hourly_rate')
              ->label('أجر الساعة المتوقع')
              ->prefix('$ ')
              ->weight('bold')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; color: #10b981;']),

            TextEntry::make('payment_method')
              ->label('طريقة الدفع')
              ->badge()
              ->color(fn($state) => $state === 'weekly' ? 'warning' : 'success')
              ->formatStateUsing(fn($state) => $state === 'weekly' ? 'أسبوعي' : 'شهري'),
          ])->columnSpanFull(),

        Section::make('تفاصيل وخبرات إضافية')
          ->icon('heroicon-o-document-plus')
          ->compact()
          ->schema([
            TextEntry::make('other_professions')
              ->label('مهارات أو مهن أخرى يجيدها')
              ->placeholder('لا يوجد مهن إضافية مسجلة لهذا العامل'),
          ])->columnSpanFull(),
      ]);
  }
}
