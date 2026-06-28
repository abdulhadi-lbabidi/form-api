<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل سجل الشركة')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('company_name')->label('اسم الشركة'),
              TextEntry::make('business_type')->label('نوع العمل'),
              TextEntry::make('owner_name')->label('اسم المالك'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('work_location')->label('موقع العمل'),
              TextEntry::make('email')->label('البريد الإلكتروني')->icon('heroicon-m-envelope'),
              TextEntry::make('phone_number')->label('رقم الهاتف')->icon('heroicon-m-phone'),
            ]),

            TextEntry::make('problems_faced')
              ->label('المشاكل المذكورة')
              ->placeholder('لا يوجد مشاكل مسجلة')
              ->columnSpanFull(),
          ])->columnSpanFull(),

        Section::make('التواريخ والنظام')
          ->icon('heroicon-o-clock')
          ->compact()
          ->columns(2)
          ->schema([
            TextEntry::make('created_at')->label('تاريخ الإنشاء')->dateTime('Y-m-d H:i A'),
          ])->columnSpanFull(),
      ]);
  }
}
