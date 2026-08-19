<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExpenseForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات المصروف الأساسية')
          ->description('أدخل تفاصيل ومبلغ المصروف بدقة.')
          ->icon('heroicon-o-banknotes')
          ->columns(2)
          ->schema([
            TextInput::make('name')
              ->label('اسم المصروف / البيان')
              ->placeholder('مثال: إيجار، فاتورة كهرباء، أدوات مكتبية')
              ->required()
              ->maxLength(255)
              ->columnSpanFull(),

            TextInput::make('amount')
              ->label('المبلغ')
              ->numeric()
              ->step('0.01') // ⬅️ للسماح بإدخال الكسور العشرية (مثل 50.25)
              ->minValue(0)
              ->required()
              ->placeholder('0.00')
              ->columnSpanFull(),
          ])
          ->columnSpanFull(),
      ]);
  }
}
