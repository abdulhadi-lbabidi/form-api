<?php

namespace App\Filament\Resources\CompanyBranches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyBranchForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات فرع الشركة')
          ->description('أدخل اسم الفرع وحدد الشركة التابع لها بالإضافة للموقع التفصيلي.')
          ->icon('heroicon-o-building-office')
          ->columns(2)
          ->schema([

            Select::make('company_id')
              ->relationship('company', 'company_name')
              ->label('الشركة الرئيسية')
              ->placeholder('اختر الشركة التي يتبع لها هذا الفرع')
              ->searchable()
              ->preload()
              ->required()
              ->columnSpanFull(),

            TextInput::make('branch_name')
              ->label('اسم الفرع')
              ->placeholder('مثال: فرع المنطقة الحرة، فرع دمشق الرئيسي')
              ->required()
              ->maxLength(255),

            TextInput::make('location_address')
              ->label('عنوان الموقع التفصيلي')
              ->placeholder('المحافظة، الشارع، البناء')
              ->maxLength(255),

          ])->columnSpanFull(),
      ]);
  }
}
