<?php

namespace App\Filament\Resources\FailedRegistrationAttempts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FailedRegistrationAttemptInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل محاولة التسجيل الفاشلة')
          ->description('معلومات الأمان والبيانات التقنية للمحاولة المرفوضة.')
          ->icon('heroicon-o-shield-exclamation')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('target_type')
                ->label('نوع الجهة المستهدفة')
                ->badge()
                ->color('danger'),

              TextEntry::make('phone')
                ->label('رقم الهاتف المحاول')
                ->placeholder('-')
                ->badge()
                ->color('warning'),

              TextEntry::make('ip_address')
                ->label('عنوان IP')
                ->placeholder('-')
                ->icon('heroicon-m-globe-alt'),

              TextEntry::make('created_at')
                ->label('وقت المحاولة')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A'),

              TextEntry::make('platform')
                ->label('نص النظام / المنصة')
                ->placeholder('-'),


              TextEntry::make('payload')
                ->label('البيانات المرسلة (Payload)')
                ->formatStateUsing(fn($state) => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                ->columnSpanFull()
                ->badge()
                ->color('gray'),

              TextEntry::make('browser')
                ->label('المتصفح')
                ->placeholder('-'),
            ]),

            TextEntry::make('user_agent')
              ->label('User Agent')
              ->placeholder('-')
              ->columnSpanFull(),
          ])
          ->columnSpanFull(),
      ]);
  }
}
