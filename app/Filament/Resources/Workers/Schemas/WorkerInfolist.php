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
          ->schema([
            Grid::make(4)->schema([
              TextEntry::make('first_name')->label('الاسم الأول'),
              TextEntry::make('last_name')->label('العائلة'),
              TextEntry::make('father_name')->label('اسم الأب'),
              TextEntry::make('mother_fullname')->label('اسم الأم'),
            ]),
            Grid::make(3)->schema([
              TextEntry::make('age')->label('العمر'),
              TextEntry::make('marital_status')
                ->label('الحالة الاجتماعية')
                ->formatStateUsing(fn($state) => match ($state) {
                  'single' => 'عازب',
                  'married' => 'متزوج',
                  default => $state
                }),
              TextEntry::make('phone_whatsapp')->label('رقم الهاتف/واتساب')->icon('heroicon-m-phone'),
            ]),
          ])->columnSpanFull(),

        Section::make('السكن والعمل')
          ->icon('heroicon-o-briefcase')
          ->columns(3)
          ->schema([
            TextEntry::make('city')->label('المدينة'),
            TextEntry::make('residential_area')->label('المنطقة'),
            TextEntry::make('primary_profession')->label('المهنة الأساسية'),
            TextEntry::make('work_hours')->label('ساعات العمل'),
            TextEntry::make('commitment_level')->label('الالتزام'),
            TextEntry::make('expected_hourly_rate')->label('أجر الساعة')->prefix('$'),
            TextEntry::make('payment_method')
              ->label('طريقة الدفع')
              ->badge()
              ->color('success')
              ->formatStateUsing(fn($state) => $state === 'weekly' ? 'أسبوعي' : 'شهري'),
          ])->columnSpanFull(),

        Section::make('تفاصيل إضافية')
          ->compact()
          ->schema([
            TextEntry::make('other_professions')->label('مهن أخرى')->placeholder('لا يوجد'),
          ])->columnSpanFull(),
      ]);
  }
}
