<?php

namespace App\Filament\Resources\Marketings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MarketingForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات مصدر التسويق')
          ->description('أدخل اسم المصدر باللغتين العربية والإنجليزية لضمان عرضه بشكل صحيح في كافة الواجهات.')
          ->columns(2)
          ->schema([
            TextInput::make('name.ar')
              ->label('اسم المصدر (بالعربية)')
              ->placeholder('مثال: فيسبوك، بحث جوجل')
              ->required()
              ->maxLength(255),

            TextInput::make('name.en')
              ->label('اسم المصدر (بالإنجليزية)')
              ->placeholder('مثال: Facebook, Google Search')
              ->required()
              ->maxLength(255),
          ]),
      ]);
  }
}
