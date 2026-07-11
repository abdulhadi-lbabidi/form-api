<?php

namespace App\Filament\Resources\Companies\Schemas;

use App\Models\CompanyBranch;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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

            Tabs\Tab::make('احتياجات فروع الشركة')
              ->visible(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord)->schema([

                Repeater::make('branches')
                  ->relationship('branches')
                  ->label('إدارة فروع الشركة واحتياجاتها')
                  ->itemLabel(fn(array $state): ?string => $state['branch_name'] ?? 'فرع جديد واحتياجاته')
                  ->collapsible()
                  ->defaultItems(1)
                  ->createItemButtonLabel('➕ إضافة فرع جديد واحتياجاته')
                  ->schema([

                    TextInput::make('branch_name')
                      ->label('اسم الفرع')
                      ->placeholder('مثال: الفرع الأساسي، فرع حلب، فرع المنطقة الصناعية...')
                      ->required()
                      ->maxLength(255),

                    TextInput::make('location_address')
                      ->label('عنوان وموقع الفرع التفصيلي (اختياري)')
                      ->placeholder('اكتب عنوان الفرع هنا')
                      ->maxLength(255),

                    Repeater::make('needs')
                      ->relationship('needs')
                      ->label('المهن والعمالة المطلوبة لهذا الفرع')
                      ->itemLabel(fn(array $state): ?string => $state['required_profession'] ?? 'صنعة جديدة')
                      ->columns(2)
                      ->createItemButtonLabel('🔹 إضافة صنعة/مهنة لهذا الفرع')
                      ->schema([

                        TextInput::make('required_workers_count')
                          ->label('عدد العمال المطلوبين')
                          ->numeric()
                          ->minValue(1)
                          ->required(),

                        TextInput::make('required_profession')
                          ->label('المهنة أو الصنعة المطلوبة')
                          ->placeholder('مثال: نجار، كهربائي، حداد')
                          ->required()
                          ->maxLength(255),

                        Select::make('needed_at')
                          ->label('متى تحتاجهم؟')
                          ->options([
                            'today' => 'اليوم',
                            'this_week' => 'خلال أسبوع',
                            'this_month' => 'خلال شهر',
                            'not_specified_yet' => 'غير محدد بعد',
                          ])
                          ->required(),

                        Select::make('employment_type')
                          ->label('نوع الدوام')
                          ->options([
                            'full_time' => 'دوام كامل',
                            'part_time' => 'دوام جزئي',
                            'daily_wage' => 'مياومة',
                          ])
                          ->required(),

                        TextInput::make('offered_salary')
                          ->label('الأجر المعروض (اختياري)')
                          ->numeric(),

                        Select::make('currency')
                          ->label('العملة')
                          ->options([
                            'USD' => 'دولار',
                            'SYP' => 'ليرة',
                          ])
                          ->required(fn($get) => filled($get('offered_salary'))),

                        Textarea::make('additional_details')
                          ->label('تفاصيل إضافية عن احتياجك')
                          ->columnSpanFull(),
                      ]),

                  ]),
              ]),
            // end
          ]),
      ]);
  }
}
