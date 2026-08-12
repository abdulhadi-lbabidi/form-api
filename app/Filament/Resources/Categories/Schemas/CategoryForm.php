<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->label('اسم التصنيف')
          ->required()
          ->columnSpanFull(),

        Textarea::make('description')
          ->label('وصف التصنيف')
          ->columnSpanFull(),
      ]);
  }
}
