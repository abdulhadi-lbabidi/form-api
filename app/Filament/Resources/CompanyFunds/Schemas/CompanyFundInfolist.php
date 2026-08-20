<?php

namespace App\Filament\Resources\CompanyFunds\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyFundInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات صندوق الشركة')
          ->schema([
            TextEntry::make('name')
              ->label('اسم الصندوق'),

            TextEntry::make('description')
              ->label('الوصف')
              ->placeholder('لا يوجد وصف'),

            TextEntry::make('created_at')
              ->label('تاريخ الإنشاء')
              ->dateTime('Y-m-d H:i')
              ->extraAttributes(['style' => 'font-variant-numeric: lnum;']),
          ])
          ->columnSpanFull(),
      ]);
  }
}
