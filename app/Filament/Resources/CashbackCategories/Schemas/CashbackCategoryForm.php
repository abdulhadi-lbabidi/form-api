<?php

namespace App\Filament\Resources\CashbackCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackCategoryForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات التصنيف')
          ->description('أدخل تفاصيل تصنيف   الإعلان.')
          ->icon('heroicon-o-tag')
          ->schema([
            TextInput::make('name')
              ->label('اسم التصنيف')
              ->required()
              ->maxLength(255),

            Textarea::make('description')
              ->label('الوصف')
              ->maxLength(500)
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
