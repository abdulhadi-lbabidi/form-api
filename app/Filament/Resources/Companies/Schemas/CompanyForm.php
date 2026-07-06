<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;


class CompanyForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([

        Tabs::make('بيانات الشركة')
          ->columnSpanFull()
          ->tabs([

            Tabs\Tab::make('المعلومات الأساسية')
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

                TextInput::make('business_type')
                  ->label('نوع العمل / النشاط')
                  ->required()
                  ->maxLength(255),

                TextInput::make('owner_name')
                  ->label('اسم مالك الشركة')
                  ->required()
                  ->maxLength(255),

                TextInput::make('contact_person_name')
                  ->label('اسم المسؤول المباشر عن التواصل')
                  ->required()
                  ->maxLength(255),
              ]),

            Tabs\Tab::make('الاتصال والموقع')
              ->columns(2)
              ->schema([
                TextInput::make('city')
                  ->label('المدينة / المحافظة')
                  ->required(),

                TextInput::make('work_location')
                  ->label('موقع العمل التفصيلي')
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
              ]),

            Tabs\Tab::make('مصادر التسويق والتحديات')
              ->schema([
                CheckboxList::make('marketingSources')
                  ->relationship('marketingSources', 'name')
                  ->getOptionLabelFromRecordUsing(fn($record) => $record->translated_name)
                  ->label('مصادر التعرف علينا')
                  ->columns(3),

                Textarea::make('problems_faced')
                  ->label('المشاكل التي تواجهها الشركة (إن وجدت)')
                  ->placeholder('اكتب هنا أي تحديات أو مشاكل تواجه سير العمل...')
                  ->columnSpanFull(),

                TextInput::make('form_referral_code')
                  ->label('سجل بواسطة كود الإحالة')
                  ->placeholder('لم يسجل عبر كود')
                  ->disabled()
                  ->dehydrated(false),
              ]),

            Tabs\Tab::make('المرفقات والوثائق')
              ->schema([
                Section::make('الوثائق والملفات الرسمية (الهوية، الشهادات، إلخ)')
                  ->description('ارفع الصورة الشخصية والأوراق الثبوتية الخاصة بالشركة.')
                  ->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                      ->label('الملفات المرفوعة')
                      ->collection('companies')
                      ->disk('public')
                      ->image()
                      ->multiple()
                      ->reorderable()
                      ->maxSize(4096)
                      ->columnSpanFull(),
                  ]),
              ]),

          ]),
      ]);
  }
}