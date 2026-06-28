<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات الشركة الأساسية')
          ->description('أدخل تفاصيل الشركة ونوع العمل وموقعها الرئيسي.')
          ->columns(2)
          ->schema([
            TextInput::make('company_name')
              ->label('اسم الشركة')
              ->required()
              ->maxLength(255),

            TextInput::make('business_type')
              ->label('نوع العمل / النشاط')
              ->required()
              ->maxLength(255),

            TextInput::make('owner_name')
              ->label('اسم مالك الشركة')
              ->required()
              ->maxLength(255),

            TextInput::make('work_location')
              ->label('موقع العمل')
              ->required()
              ->maxLength(255),

            TextInput::make('email')
              ->label('البريد الإلكتروني')
              ->email()
              ->required()
              ->maxLength(255),

            TextInput::make('phone_number')
              ->label('رقم الهاتف')
              ->required()
              ->maxLength(255),

            Textarea::make('problems_faced')
              ->label('المشاكل التي تواجهها الشركة (إن وجدت)')
              ->placeholder('اكتب هنا أي تحديات أو مشاكل تواجه سير العمل...')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
