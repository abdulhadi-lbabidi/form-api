<?php

namespace App\Filament\Resources\KadrJobHostings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class KadrJobHostingForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Tabs::make('تفاصيل شاغر الكادر')
          ->columnSpanFull()
          ->tabs([
            Tabs\Tab::make('المعلومات الأساسية')
              ->columns(2)
              ->schema([
                Select::make('kadr_id')
                  ->label('الكادر المسؤول / المالك')
                  ->relationship('kadr', 'name')
                  ->searchable()
                  ->preload()
                  ->required()
                  ->columnSpanFull(),

                TextInput::make('title')
                  ->label('عنوان الوظيفة المطلوبة')
                  ->required()
                  ->maxLength(255),

                Select::make('categories')
                  ->label('التصنيفات')
                  ->relationship('categories', 'name')
                  ->multiple()
                  ->searchable()
                  ->preload()
                  ->required()
                  ->columnSpanFull(),

                Select::make('job_type')
                  ->label('نوع الدوام')
                  ->options([
                    'دوام كامل' => 'دوام كامل',
                    'دوام جزئي' => 'دوام جزئي',
                    'مياومة'    => 'مياومة',
                    'عقد مؤقت' => 'عقد مؤقت',
                  ])
                  ->required(),

                TextInput::make('workers_count')
                  ->label('عدد العمال المطلوبين')
                  ->numeric()
                  ->minValue(1)
                  ->required(),

                Select::make('shift_period')
                  ->label('فترة الدوام (الوردية)')
                  ->options([
                    'صباحي' => 'صباحي',
                    'مسائي' => 'مسائي',
                    'ليلي'  => 'ليلي',
                    'متناوب' => 'متناوب',
                  ])
                  ->required(),

                Select::make('experience_level')
                  ->label('مستوى الخبرة المطلوبة')
                  ->options([
                    'مبتدئ'   => 'مبتدئ',
                    'متوسط'   => 'متوسط',
                    'خبير'    => 'خبير',
                    'لا يشترط' => 'لا يشترط',
                  ])
                  ->required(),

                Select::make('status')
                  ->label('حالة الشاغر')
                  ->options([
                    'pending'  => 'قيد المراجعة (Pending)',
                    'approved' => 'معتمد / نشط (Approved)',
                    'rejected' => 'مرفوض (Rejected)',
                    'closed'   => 'مغلق (Closed)',
                  ])
                  ->required()
                  ->default('pending'),
              ]),

            Tabs\Tab::make('الموقع وأوقات الدوام')
              ->columns(2)
              ->schema([
                TextInput::make('city')
                  ->label('المدينة')
                  ->required()
                  ->maxLength(255),

                TextInput::make('district')
                  ->label('المنطقة / الحي')
                  ->maxLength(255),

                TimePicker::make('time_from')
                  ->label('ساعات الدوام من')
                  ->seconds(false),

                TimePicker::make('time_to')
                  ->label('ساعات الدوام إلى')
                  ->seconds(false),
              ]),

            Tabs\Tab::make('تفاصيل الرواتب والملاحظات')
              ->columns(2)
              ->schema([
                TextInput::make('salary_min')
                  ->label('الحد الأدنى للراتب')
                  ->numeric()
                  ->minValue(0),

                TextInput::make('salary_max')
                  ->label('الحد الأعلى للراتب')
                  ->numeric()
                  ->minValue(0),

                Select::make('currency')
                  ->label('العملة')
                  ->options([
                    'ل.س' => 'ليرة سورية',
                    'USD' => 'دولار أمريكي',
                  ])
                  ->required(),

                Select::make('salary_interval')
                  ->label('دورية دفع الراتب')
                  ->options([
                    'يومي'   => 'يومي',
                    'أسبوعي' => 'أسبوعي',
                    'شهري'   => 'شهري',
                  ])
                  ->required(),

                Textarea::make('notes')
                  ->label('ملاحظات تفصيلية وشروط إضافية')
                  ->placeholder('اكتب أي شروط أو تفاصيل تخص الوظيفة هنا...')
                  ->columnSpanFull(),
              ]),
          ]),
      ]);
  }
}
