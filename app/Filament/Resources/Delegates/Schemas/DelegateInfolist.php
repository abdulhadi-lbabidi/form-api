<?php

namespace App\Filament\Resources\Delegates\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DelegateInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات المندوب')
          ->description('تفاصيل الحساب، الراتب، ونسب العمولة الخاصة بالمندوب')
          ->icon('heroicon-o-identification')
          ->schema([
            Grid::make([
              'default' => 1,
              'sm' => 2,
              'lg' => 3,
            ])
              ->schema([
                TextEntry::make('user.name')
                  ->label('اسم المستخدم')
                  ->icon('heroicon-m-user')
                  ->weight('bold'),

                TextEntry::make('user.email')
                  ->label('البريد الإلكتروني')
                  ->icon('heroicon-m-envelope')
                  ->color('primary'),

                TextEntry::make('user.phone_number')
                  ->label('رقم الهاتف')
                  ->icon('heroicon-m-phone')
                  ->placeholder('غير متوفر'),

                TextEntry::make('address')
                  ->label('عنوان السكن')
                  ->icon('heroicon-m-map-pin')
                  ->placeholder('-'),

                TextEntry::make('fixed_salary')
                  ->label('الراتب الثابت'),

                TextEntry::make('commission_rate')
                  ->label('قيمة/نسبة العمولة')
                  ->icon('heroicon-m-chart-bar'),

                TextEntry::make('created_at')
                  ->label('تاريخ الإضافة')
                  ->icon('heroicon-m-calendar')
                  ->dateTime('Y-m-d h:i A'),
              ]),
          ])
          ->columnSpanFull(),

        Section::make('تفاصيل ووصف العمولة')
          ->description('الشروط أو الآلية المتبعة لاحتساب العمولة')
          ->icon('heroicon-o-document-text')
          ->schema([
            TextEntry::make('commission_description')
              ->label('')
              ->placeholder('لا يوجد وصف مضاف للعمولة'),
          ])
          ->columnSpanFull(),
      ]);
  }
}
