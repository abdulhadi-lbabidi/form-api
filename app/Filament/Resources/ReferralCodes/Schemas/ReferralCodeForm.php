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
            Select::make('referralable_type')
              ->label('صاحب الكود (النوع)')
              ->options([
                'App\Models\Company' => 'شركة',
                'App\Models\Worker' => 'عامل',
              ])
              ->required()
              ->live(),

            Select::make('referralable_id')
              ->label('اسم صاحب الكود')
              ->placeholder('اختر الجهة أولاً')
              ->searchable()
              ->required()
              ->options(function (Get $get) {
                $type = $get('referralable_type');
                if (! $type) return [];

                return $type === 'App\Models\Company'
                  ? \App\Models\Company::pluck('company_name', 'id')
                  : \App\Models\Worker::all()->mapWithKeys(fn($w) => [$w->id => "{$w->first_name} {$w->last_name}"]);
              }),

            TextInput::make('code')
              ->label('كود الإحالة')
              ->placeholder('سيتم توليده تلقائياً')
              ->disabled()
              ->dehydrated(false)
              ->visible(fn($record) => $record !== null),

            TextInput::make('usage_limit')
              ->label('حد الاستخدام الأقصى')
              ->numeric()
              ->placeholder('اتركه فارغاً ليكون غير محدود'),

            TextInput::make('times_used')
              ->label('عدد مرات الاستخدام الحالي')
              ->numeric()
              ->default(0)
              ->disabled(), 

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
