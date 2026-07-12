<?php

namespace App\Filament\Resources\CompanyNeeds\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyNeedForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('القسم 2: شو محتاج؟')
          ->description('أدخل تفاصيل احتياجات فرع الشركة من العمال والمهن المطلوبة.')
          ->icon('heroicon-o-briefcase')
          ->columns(2)
          ->schema([

            Select::make('company_branch_id')
              ->relationship(
                name: 'branch',
                titleAttribute: 'branch_name',
                modifyQueryUsing: fn($query) => $query->join('companies', 'company_branches.company_id', '=', 'companies.id')
                  ->select('company_branches.*', 'companies.company_name')
              )
              ->getOptionLabelFromRecordUsing(fn($record) => "{$record->company_name} - {$record->branch_name}")
              ->label('فرع الشركة')
              ->placeholder('اختر الفرع المحتاج للعمال')
              ->searchable(['companies.company_name', 'branch_name']) 
              ->preload()
              ->required()
              ->columnSpanFull(),

            TextInput::make('required_workers_count')
              ->label('عدد العمال المطلوبين')
              ->numeric()
              ->minValue(1)
              ->required(),

            TextInput::make('required_profession')
              ->label('المهنة أو الصنعة المطلوبة')
              ->placeholder('مثال: نجار، كهربائي، عامل بناء')
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
              ->numeric()
              ->placeholder('يساعدنا نلاقيلك العامل الأسرع'),

            Select::make('currency')
              ->label('العملة')
              ->options([
                'USD' => 'دولار',
                'SYP' => 'ليرة',
              ])
              ->required(fn($get) => filled($get('offered_salary'))),

            Textarea::make('additional_details')
              ->label('تفاصيل إضافية عن احتياجك')
              ->placeholder('احكيلنا أي تفاصيل بتساعدنا نفهم شغلك أكتر — مثال: نوع المشروع، ساعات العمل، مهارات معينة...')
              ->columnSpanFull(),

          ])->columnSpanFull(),
      ]);
  }
}
