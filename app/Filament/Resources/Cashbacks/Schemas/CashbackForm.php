<?php

namespace App\Filament\Resources\Cashbacks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الإعلان')
          ->description('أدخل تفاصيل  الإعلان بدقة.')
          ->icon('heroicon-o-gift')
          ->schema([
            TextInput::make('company_name')
              ->label('اسم الشركة')
              ->required()
              ->maxLength(255),

            Select::make('categories')
              ->label('تصنيفات الإعلان')
              ->relationship('categories', 'name')
              ->multiple()
              ->searchable()
              ->preload()
              ->required()
              ->columnSpanFull(),

            TextInput::make('reasone')
              ->label('السبب')
              ->maxLength(255),

            Toggle::make('is_favorite')
              ->label('مفضلة (Favorite)')
              ->default(false)
              ->columnSpanFull(),

            TextInput::make('redirect_url')
              ->label('رابط التوجيه (Redirect URL)')
              ->url()
              ->maxLength(255)
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
