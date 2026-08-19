<?php

namespace App\Filament\Resources\Kadrs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KadrInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الكادر')
          ->description('المعلومات الأساسية وبيانات الاتصال والموقع الخاص بالكادر.')
          ->icon('heroicon-o-user')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('name')
                ->label('الاسم')
                ->weight('bold'),

              TextEntry::make('number_of_person')
                ->label('عدد الأشخاص')
                ->placeholder('لا يوجد'),

              TextEntry::make('city')
                ->label('المدينة')
                ->icon('heroicon-m-map-pin')
                ->color('primary'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('phone')
                ->label('رقم الهاتف')
                ->icon('heroicon-m-phone')
                ->color('success')
                ->copyable()
                ->url(fn($record) => "tel:{$record->phone}"),

              TextEntry::make('email')
                ->label('البريد الإلكتروني')
                ->icon('heroicon-m-envelope')
                ->color('info')
                ->copyable()
                ->placeholder('لا يوجد'),

              TextEntry::make('created_at')
                ->label('تاريخ الإنشاء')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A'),
            ]),

            TextEntry::make('shop_address')
              ->label('عنوان المحل / العمل')
              ->placeholder('لا يوجد عنوان مسجل')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
