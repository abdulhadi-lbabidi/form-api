<?php

namespace App\Filament\Resources\Notifications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NotificationInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الإشعار')
          ->description('معلومات الإشعار والمرسل إليه والتوقيت.')
          ->icon('heroicon-o-bell')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('notifiable.name')
                ->label('المستلم')
                ->icon('heroicon-m-user')
                ->badge()
                ->color('info'),

              TextEntry::make('created_at')
                ->label('وقت الإرسال')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A'),
            ]),

            TextEntry::make('data.title')
              ->label('عنوان الإشعار')
              ->weight('bold'),

            TextEntry::make('data.body')
              ->label('محتوى الإشعار')
              ->columnSpanFull(),

            TextEntry::make('read_at')
              ->label('حالة القراءة')
              ->formatStateUsing(fn($state) => $state ? 'مقروء' : 'غير مقروء')
              ->badge()
              ->color(fn($state) => $state ? 'success' : 'danger'),
          ])
          ->columnSpanFull(),
      ]);
  }
}
