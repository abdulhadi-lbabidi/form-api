<?php

namespace App\Filament\Resources\KadrNeeds\Schemas;

use App\Models\Worker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KadrNeedForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل احتياج الكادر')
          ->description('أدخل تفاصيل احتياجات الكادر من العمال والمهن المطلوبة.')
          ->icon('heroicon-o-briefcase')
          ->columns(2)
          ->schema([

            Select::make('kadr_id')
              ->relationship(
                name: 'kadr',
                titleAttribute: 'name'
              )
              ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} - ({$record->phone})")
              ->label('الكادر / صاحب العمل')
              ->placeholder('اختر الكادر المحتاج للعمال')
              ->searchable(['name', 'phone'])
              ->preload()
              ->required()
              ->columnSpanFull(),

            Select::make('workers')
              ->relationship('workers', 'full_name')
              ->label('العمال المرتبطين بالاحتياج')
              ->placeholder('اختر العمال المناسبين لهذا الاحتياج')
              ->multiple()
              ->reactive()
              ->afterStateUpdated(function ($state, callable $set) {
                $count = is_array($state) ? count($state) : 0;
                $set('required_workers_count', $count > 0 ? $count : null);
              })
              ->searchable(['full_name', 'phone_whatsapp', 'code'])
              ->getOptionLabelFromRecordUsing(fn(Worker $record) => "{$record->full_name} ({$record->primary_profession}) - {$record->code}")
              ->preload()
              ->pivotData(fn($get) => [
                'status' => $get('worker_default_status') ?? 'pending',
              ])
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
              ->placeholder('الأجر المقترح للعامل'),

            Select::make('currency')
              ->label('العملة')
              ->options([
                'USD' => 'دولار',
                'SYP' => 'ليرة',
              ])
              ->required(fn($get) => filled($get('offered_salary'))),

            Textarea::make('additional_details')
              ->label('تفاصيل إضافية عن الاحتياج')
              ->placeholder('اكتب أي تفاصيل إضافية هنا...')
              ->columnSpanFull(),

          ])->columnSpanFull(),
      ]);
  }
}
