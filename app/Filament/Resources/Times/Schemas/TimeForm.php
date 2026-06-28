<?php

namespace App\Filament\Resources\Times\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TimeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('الفترة الزمنية')
          ->description('تحديد أو تعديل مسمى فترة الدوام.')
          ->icon('heroicon-o-clock')
          ->maxWidth('xl')
          ->schema([
            TextInput::make('work_time')
              ->label('وقت العمل / الفترة')
              ->placeholder('مثال: 06:00 AM - 06:15 AM')
              ->required()
              ->maxLength(255),
          ])->columnSpanFull(),
      ]);
  }
}
