<?php

namespace App\Filament\Resources\Currencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CurrencyForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات العملة')
          ->description('أدخل اسم العملة والرمز المختصر الخاص بها.')
          ->icon('heroicon-o-currency-dollar')
          ->columns(2)
          ->schema([
            TextInput::make('name')
              ->label('اسم العملة')
              ->placeholder('مثال: دولار أمريكي، ليرة سورية')
              ->required()
              ->maxLength(255),

            TextInput::make('symbol')
              ->label('رمز العملة')
              ->placeholder('مثال: USD, SYP')
              ->required()
              ->maxLength(10)
              ->unique(table: 'currencies', column: 'symbol', ignoreRecord: true),
          ])
          ->columnSpanFull(),
      ]);
  }
}
