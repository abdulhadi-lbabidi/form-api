<?php

namespace App\Filament\Resources\Funds\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FundForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الصندوق المالي')
          ->description('أدخل اسم الصندوق، الرصيد الحالي، والحد الأدنى للسحب.')
          ->icon('heroicon-o-wallet')
          ->columns(2)
          ->schema([
            TextInput::make('name')
              ->label('اسم الصندوق')
              ->placeholder('مثال: الصندوق الرئيسي، صندوق العمولة')
              ->required()
              ->maxLength(255)
              ->columnSpanFull(),


            Select::make('user_id')
              ->label('المستخدم المسؤول / المالك')
              ->relationship('user', 'name')
              ->searchable()
              ->preload()
              ->placeholder('اختر مستخدماً (أو اتركه فارغاً لصندوق عام)')
              ->columnSpanFull(),

            Textarea::make('description')
              ->label('وصف الصندوق (اختياري)')
              ->placeholder('اكتب تفاصيل أو ملاحظات عن هذا الصندوق...')
              ->columnSpanFull(),
          ])
          ->columnSpanFull(),
      ]);
  }
}
