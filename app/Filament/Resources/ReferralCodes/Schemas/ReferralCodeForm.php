<?php

namespace App\Filament\Resources\ReferralCodes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ReferralCodeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('إنشاء وتخصيص كود الإحالة')
          ->icon('heroicon-o-ticket')
          ->columns(2)
          ->schema([
            // اختيار نوع صاحب الكود
            Select::make('referralable_type')
              ->label('صاحب الكود (النوع)')
              ->options([
                'App\Models\Company' => 'شركة',
                'App\Models\Worker' => 'عامل',
              ])
              ->required()
              ->live(), // يجعل الحقل تفاعلياً لتحديث الحقل التالي فوراً

            // اختيار الكيان المحدد بناءً على النوع المختار
            Select::make('referralable_id')
              ->label('اسم صاحب الكود')
              ->placeholder('اختر الجهة أولاً')
              ->searchable()
              ->required()
              ->options(function (Get $get) {
                $type = $get('referralable_type');
                if (! $type) return [];

                // إذا كان شركة نجلب أسماء الشركات، وإذا كان عامل نجلب أسماء العمال
                return $type === 'App\Models\Company'
                  ? \App\Models\Company::pluck('company_name', 'id')
                  : \App\Models\Worker::all()->mapWithKeys(fn($w) => [$w->id => "{$w->first_name} {$w->last_name}"]);
              }),

            // حقل الكود (يظهر كتلميح عند الإنشاء ويولد تلقائياً، ويصبح ظاهراً عند التعديل)
            TextInput::make('code')
              ->label('كود الإحالة')
              ->placeholder('سيتم توليده تلقائياً')
              ->disabled() // حماية لعدم التعديل اليدوي العشوائي
              ->dehydrated(false) // عدم إرساله في الـ Request عند الإنشاء لأنه يتولد بالموديل
              ->visible(fn($record) => $record !== null), // يظهر فقط عند التعديل أو العرض

            TextInput::make('usage_limit')
              ->label('حد الاستخدام الأقصى')
              ->numeric()
              ->placeholder('اتركه فارغاً ليكون غير محدود'),

            TextInput::make('times_used')
              ->label('عدد مرات الاستخدام الحالي')
              ->numeric()
              ->default(0)
              ->disabled(), // للمشاهدة فقط ولا يمكن تزويره يدوياً

            DateTimePicker::make('expires_at')
              ->label('تاريخ انتهاء الصلاحية')
              ->placeholder('صالح دائماً ما لم يحدد تاريخ'),

            Toggle::make('is_active')
              ->label('حالة الكود (نشط)')
              ->default(true)
              ->inline(false)
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
