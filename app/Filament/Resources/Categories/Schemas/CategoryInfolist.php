<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات التصنيف')
          ->icon('heroicon-o-tag')
          ->columns(3)
          ->schema([
            TextEntry::make('name')
              ->label('اسم التصنيف')
              ->weight('bold'),

            TextEntry::make('workers_count')
              ->label('إجمالي عدد العمال')
              ->state(fn($record) => $record->workers()->count())
              ->badge()
              ->color('success'),

            TextEntry::make('description')
              ->label('الوصف')
              ->placeholder('لا يوجد وصف لهذا التصنيف')
              ->columnSpanFull(),
          ])->columnSpanFull(),

      ]);
  }
}
