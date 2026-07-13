<?php

namespace App\Filament\Resources\Workers\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
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
                  ->label('الاسم الأول'),

                TextInput::make('last_name')
                  ->label('الكنية / اسم العائلة'),

                TextInput::make('father_name')
                  ->label('اسم الأب'),

                TextInput::make('mother_fullname')
                  ->label('اسم الأم الكامل'),

                TextInput::make('full_name')
                  ->label('الاسم الكامل'),


                DatePicker::make('age')
                  ->label('تاريخ الميلاد')
                  ->required()
                  ->native(false)
                  ->displayFormat('Y-m-d'),

                Select::make('marital_status')
                  ->label('الحالة الاجتماعية')
                  ->options([
                    'single' => 'عازب',
                    'married' => 'متزوج ويعيل أسرة',
                    'other' => 'غير ذلك'
                  ])
                  ->required(),
              ]),

            Tabs\Tab::make('الاتصال والسكن')
              ->columns(2)
              ->schema([
                TextInput::make('phone_whatsapp')
                  ->label('رقم الهاتف / واتساب')
                  ->required()
                  ->unique(table: 'workers', column: 'phone_whatsapp', ignoreRecord: true)
                  ->validationMessages([
                    'unique' => 'رقم الهاتف هذا مسجل مسبقاً لعامل آخر.',
                  ]),

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


                Select::make('work_hours')
                  ->label('دوام العمل المتاح')
                  ->options([
                    'morning' => 'صباحي',
                    'evening' => 'مسائي',
                    'night' => 'ليلي',
                    'for_all_times' => 'متاح لجميع الأوقات'
                  ])
                  ->required(),

                Select::make('commitment_level')
                  ->label('الالتزام بالعمل')
                  ->options([
                    'full_time' => 'دوام كامل',
                    'part_time' => 'دوام جزئي',
                    'hourly' => 'بالساعة'
                  ])
                  ->required(),

                Select::make('working_status')
                  ->label('حالة العمل الحالية')
                  ->options([
                    'working_now' => 'اعمل حالياً',
                    'not_working' => 'لا أعمل حالياً',
                    'part_time'   => 'نعم بدوام جزئي',
                    'full_time'   => 'نعم بدوام كامل',
                  ])
                  ->required(),

                CheckboxList::make('marketingSources')
                  ->relationship('marketingSources', 'name')
                  ->getOptionLabelFromRecordUsing(fn($record) => $record->translated_name)
                  ->label('مصادر التعرف علينا')
                  ->columns(3),


                TextInput::make('expected_hourly_rate_usd')
                  ->label('أجر الساعة المتوقع (USD)')
                  ->numeric()
                  ->prefix('$')
                  ->default(0.00),

                TextInput::make('expected_hourly_rate_syp')
                  ->label('أجر الساعة المتوقع (SYP)')
                  ->numeric()
                  ->prefix('ل.س')
                  ->default(0.00),

                Select::make('payment_method')
                  ->label('طريقة الدفع المفضلة')
                  ->options([
                    'weekly' => 'أسبوعي',
                    'monthly' => 'شهري',
                    'daily' => 'يومي',
                  ])
                  ->required(),
                Textarea::make('other_professions')
                  ->label('مهارات أو مهن أخرى يجيدها')
                  ->columnSpanFull(),

                Select::make('worker_status')
                  ->label('حالة العامل بالنظام')
                  ->options([
                    'new_registered' => 'مسجّل جديد',
                    'contacted'      => 'تم التواصل',
                    'verified'       => 'تم التوثيق',
                    'job_hunting'    => 'في مرحلة البحث عن عمل',
                    'sent_to_client' => 'تم إرساله إلى صاحب العمل',
                    'hired'          => 'تم التوظيف',
                    'working_now'    => 'على رأس عمله',
                    'frozen'         => 'مجمد / غير متاح',
                    'blocked'        => 'محظور - غير كفوء',
                  ])
                  ->required()
                  ->default('new_registered'),
              ]),

            // Attachments
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
                      ->maxSize(4096)
                      ->columnSpanFull(),
                  ]),
              ]),


          ]),
      ]);
  }
}