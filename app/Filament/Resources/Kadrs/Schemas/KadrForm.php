<?php

namespace App\Filament\Resources\Kadrs\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KadrForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Tabs::make('بيانات الكادر')
          ->columnSpanFull()
          ->tabs([

            Tabs\Tab::make('المعلومات الشخصية')
              ->columns(2)
              ->schema([
                TextInput::make('name')
                  ->label('الاسم الكامل')
                  ->required()
                  ->maxLength(255)
                  ->columnSpanFull(),

                TextInput::make('first_name')
                  ->label('الاسم الأول')
                  ->maxLength(255),

                TextInput::make('last_name')
                  ->label('الكنية / اسم العائلة')
                  ->maxLength(255),

                TextInput::make('father_name')
                  ->label('اسم الأب')
                  ->maxLength(255),

                DatePicker::make('date_of_birth')
                  ->label('تاريخ الميلاد')
                  ->native(false)
                  ->displayFormat('Y-m-d'),

                TextInput::make('phone')
                  ->label('رقم الهاتف')
                  ->required()
                  ->unique(table: 'kadrs', column: 'phone', ignoreRecord: true)
                  ->maxLength(255),

                TextInput::make('email')
                  ->label('البريد الإلكتروني')
                  ->email()
                  ->nullable()
                  ->maxLength(255),

                TextInput::make('password')
                  ->label('كلمة المرور')
                  ->password()
                  ->revealable()
                  ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                  ->dehydrated(fn($state) => filled($state))
                  ->required(fn(string $context): bool => $context === 'create')
                  ->placeholder('اتركه فارغاً للإبقاء على كلمة المرور الحالية')
                  ->maxLength(255)
                  ->columnSpanFull(),
              ]),

            Tabs\Tab::make('معلومات العمل والخدمة')
              ->columns(2)
              ->schema([
                TextInput::make('service_type')
                  ->label('ما نوع الخدمة التي تقدمها؟')
                  ->maxLength(255)
                  ->columnSpanFull(),

                Toggle::make('has_team')
                  ->label('هل لديك كادر (فريق عمل)؟')
                  ->reactive()
                  ->columnSpanFull(),

                TextInput::make('number_of_person')
                  ->label('عدد أفراد الفريق')
                  ->numeric()
                  ->visible(fn($get) => $get('has_team') == true)
                  ->columnSpanFull(),
              ]),

            Tabs\Tab::make('الموقع والعنوان')
              ->columns(2)
              ->schema([
                TextInput::make('city')
                  ->label('المدينة / المحافظة')
                  ->maxLength(255),

                TextInput::make('residential_area')
                  ->label('منطقة السكن / الحي')
                  ->maxLength(255),

                TextInput::make('shop_address')
                  ->label('عنوان المحل / العمل')
                  ->maxLength(255)
                  ->columnSpanFull(),
              ]),

            Tabs\Tab::make('الروابط والتسويق')
              ->schema([
                TextInput::make('social_or_website_link')
                  ->label('رابط الموقع الإلكتروني أو وسائل التواصل الاجتماعي')
                  ->url()
                  ->maxLength(255),

                CheckboxList::make('marketingSources')
                  ->relationship('marketingSources', 'name')
                  ->getOptionLabelFromRecordUsing(fn($record) => $record->translated_name)
                  ->label('مصادر التعرف علينا')
                  ->columns(3),
              ]),

            Tabs\Tab::make('المرفقات والوثائق')
              ->schema([
                Section::make('الملفات والسيرة الذاتية (CV / Portfolio)')
                  ->description('ارفع الملفات الثبوتية أو السيرة الذاتية الخاصة بالكادر.')
                  ->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                      ->label('الملفات المرفوعة (صور أو ملفات PDF)')
                      ->collection('kadrs')
                      ->disk('public')
                      ->acceptedFileTypes([
                        'image/*',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                      ])
                      ->multiple()
                      ->reorderable()
                      ->maxSize(5120)
                      ->columnSpanFull(),
                  ]),
              ]),

          ]),
      ]);
  }
}
