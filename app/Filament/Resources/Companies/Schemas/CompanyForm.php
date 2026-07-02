<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
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

            Toggle::make('is_verified')
              ->label('حالة التوثيق (Verified)')
              ->helperText('تفعيل هذا الخيار سيقوم بتوليد رمز فريد للشركة بشكل تلقائي.')
              ->onColor('success')
              ->offColor('danger')
              ->columnSpanFull(),

            TextInput::make('company_name')
              ->label('اسم الشركة')
              ->required()
              ->maxLength(255),

            TextInput::make('city')
              ->label('المدينة / المحافظة')
              ->required(),

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

            TextInput::make('form_referral_code')
              ->label('سجل بواسطة كود الإحالة')
              ->placeholder('لم يسجل عبر كود')
              ->disabled()
              ->dehydrated(false),


          ])->columnSpanFull(),

        Section::make('الوثائق والملفات الرسمية (الهوية، الشهادات، إلخ)')
          ->description('ارفع الصورة الشخصية والأوراق الثبوتية الخاصة بالشركة.')
          ->columnSpanFull()
          ->schema([
            SpatieMediaLibraryFileUpload::make('image')
              ->label('الملفات المرفوعة')
              ->collection('companies')
              ->disk('public')
              ->image()
              ->multiple()
              ->reorderable()
              ->columnSpanFull(),
          ]),
      ]);
  }
}
