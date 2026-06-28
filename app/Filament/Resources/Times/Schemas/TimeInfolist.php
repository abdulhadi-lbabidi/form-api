<?php

namespace App\Filament\Resources\Times\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TimeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('بيانات الوقت')
          ->icon('heroicon-o-information-circle')
          ->maxWidth('2xl')
          ->schema([
            TextEntry::make('work_time')
              ->label('الفترة الزمنية المسجلة')
              ->weight('bold')
              ->icon('heroicon-m-clock'),

            TextEntry::make('created_at')
              ->label('تاريخ الإنشاء')
              ->dateTime('Y-m-d H:i A'),

          ])->columnSpanFull(),
      ]);
  }
}
