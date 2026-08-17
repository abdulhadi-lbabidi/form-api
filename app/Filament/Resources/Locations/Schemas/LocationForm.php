<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LocationForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('بيانات المنطقة والموقع')
          ->icon('heroicon-o-map-pin')
          ->description('أدخل اسم المنطقة وإحداثيات خطوط الطول والعرض (JSON).')
          ->columns(1)
          ->schema([
            TextInput::make('name')
              ->label('اسم المنطقة')
              ->required()
              ->maxLength(255),

            Textarea::make('coordinates')
              ->label('الإحداثيات (JSON Coordinates)')
              ->required()
              ->rows(6)
              ->helperText('أدخل الإحداثيات بصيغة JSON الصحيحة، مثال: [[36.198, 37.086], [36.185, 37.088]]')
              // تحويل المصفوفة إلى نص JSON لعرضها في الحقل، والعكس عند الحفظ
              ->formatStateUsing(fn($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
              ->dehydrateStateUsing(fn($state) => is_string($state) ? json_decode($state, true) : $state),
          ])
          ->columnSpanFull(),
      ]);
  }
}
