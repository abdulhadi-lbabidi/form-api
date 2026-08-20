<?php

namespace App\Filament\Resources\CompanyFunds\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompanyFundForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')->required()->label('اسم الصندوق'),
        Textarea::make('description')->label('الوصف'),
      ]);
  }
}
