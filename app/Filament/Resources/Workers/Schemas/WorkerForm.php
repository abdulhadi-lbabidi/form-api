<?php

namespace App\Filament\Resources\Workers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Section;

class WorkerForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Tabs::make('بيانات العامل')
          ->columnSpanFull()
          ->tabs([
            Tabs\Tab::make('المعلومات الشخصية')
              ->columns(2)
              ->schema([

                Toggle::make('is_verified')
                  ->label('حالة التوثيق (Verified)')
                  ->helperText('تفعيل التوثيق سيقوم بتوليد رمز فريد للعامل تلقائياً.')
                  ->onColor('success')
                  ->offColor('danger')
                  ->columnSpanFull(),

                TextInput::make('first_name')
                  ->label('الاسم الأول')
                  ->required(),
                TextInput::make('last_name')
                  ->label('الكنية / اسم العائلة')
                  ->required(),
                TextInput::make('father_name')
                  ->label('اسم الأب')
                  ->required(),
                TextInput::make('mother_fullname')
                  ->label('اسم الأم الكامل')
                  ->required(),
                TextInput::make('age')
                  ->label('العمر')
                  ->numeric()
                  ->required(),
                Select::make('marital_status')
                  ->label('الحالة الاجتماعية')
                  ->options([
                    'single' => 'عازب',
                    'married' => 'متزوج',
                    'other' => 'غير ذلك'
                  ])
                  ->required(),
              ]),

            Tabs\Tab::make('الاتصال والسكن')
              ->columns(2)
              ->schema([
                TextInput::make('phone_whatsapp')
                  ->label('رقم الهاتف / واتساب')
                  ->required(),
                TextInput::make('city')
                  ->label('المدينة / المحافظة')
                  ->required(),
                TextInput::make('residential_area')
                  ->label('منطقة السكن / العنوان')
                  ->required(),

                TextInput::make('form_referral_code')
                  ->label('سجل بواسطة كود الإحالة')
                  ->placeholder('لم يسجل عبر كود')
                  ->disabled()
                  ->dehydrated(false),

              ]),

            Tabs\Tab::make('المهنة والتفاصيل المالية')
              ->columns(2)
              ->schema([
                TextInput::make('primary_profession')
                  ->label('المهنة الأساسية')
                  ->required(),
                TextInput::make('work_hours')
                  ->label('ساعات الدوام المتاحة')
                  ->placeholder('مثال: 8 ساعات، صباحي...')
                  ->required(),
                TextInput::make('commitment_level')
                  ->label('مستوى الالتزام')
                  ->placeholder('مثال: دوام كامل، جزئي...')
                  ->required(),

                TextInput::make('expected_hourly_rate_usd')
                  ->label('أجر الساعة المتوقع (USD)')
                  ->numeric()
                  ->prefix('$')
                  ->default(0)
                  ->formatStateUsing(fn($state) => $state ?? 0)
                  ->mutateDehydratedStateUsing(fn($state) => empty($state) ? 0 : $state),

                TextInput::make('expected_hourly_rate_syp')
                  ->label('أجر الساعة المتوقع (SYP)')
                  ->numeric()
                  ->prefix('ل.س')
                  ->default(0)
                  ->formatStateUsing(fn($state) => $state ?? 0)
                  ->mutateDehydratedStateUsing(fn($state) => empty($state) ? 0 : $state),

                Select::make('payment_method')
                  ->label('طريقة الدفع المفضلة')
                  ->options([
                    'weekly' => 'أسبوعي',
                    'monthly' => 'شهري',
                  ])
                  ->required(),
                Textarea::make('other_professions')
                  ->label('مهارات أو مهن أخرى يجيدها')
                  ->columnSpanFull(),







              ]),

            Tabs\Tab::make('المرفقات والوثائق')
              ->schema([
                Section::make('الوثائق والملفات الرسمية (الهوية، الشهادات، إلخ)')
                  ->description('ارفع الصورة الشخصية والأوراق الثبوتية الخاصة بالعامل.')
                  ->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                      ->label('الملفات المرفوعة')
                      ->collection('workers')
                      ->disk('public')
                      ->image()
                      ->multiple()
                      ->reorderable()
                      ->columnSpanFull(),
                  ]),
              ]),


          ]),
      ]);
  }
}
