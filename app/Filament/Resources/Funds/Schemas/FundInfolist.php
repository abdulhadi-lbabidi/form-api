<?php

namespace App\Filament\Resources\Funds\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FundInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الصندوق المالي')
          ->description('عرض بيانات الصندوق والرصيد والحد الأدنى للسحب.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('name')
                ->label('اسم الصندوق')
                ->weight('bold')
                ->color('primary'),



              TextEntry::make('user.name')
                ->label('المستخدم المسؤول / المالك')
                ->placeholder('غير محدد')
                ->icon('heroicon-m-user'),

              TextEntry::make('created_at')
                ->label('تاريخ الإنشاء')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-calendar')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),

            TextEntry::make('description')
              ->label('وصف الصندوق')
              ->placeholder('لا توجد تفاصيل إضافية.')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
