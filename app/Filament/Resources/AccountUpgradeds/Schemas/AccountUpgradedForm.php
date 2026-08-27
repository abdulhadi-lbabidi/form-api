<?php

namespace App\Filament\Resources\AccountUpgradeds\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccountUpgradedForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات ترقية الحساب')
          ->description('أدخل تفاصيل الترقية والتواريخ والعمولة.')
          ->icon('heroicon-o-shield-check')
          ->schema([
            Select::make('account_upgrade_request_id')
              ->label('طلب الترقية المرتبط')
              ->relationship('accountUpgradeRequest', 'id')
              ->getOptionLabelFromRecordUsing(fn($record) => "طلب #" . $record->id . " (" . class_basename($record->morphable_type) . ")")
              ->searchable()
              ->preload()
              ->required()
              ->columnSpanFull(),

            DatePicker::make('start_date')
              ->label('تاريخ البداية')
              ->required()
              ->native(false),

            DatePicker::make('end_date')
              ->label('تاريخ النهاية')
              ->required()
              ->native(false)
              ->after('start_date'),

            TextInput::make('comosion')
              ->label('العمولة')
              ->numeric()
              ->prefix('$')
              ->maxValue(999999.99),

            Select::make('status')
              ->label('الحالة')
              ->options([
                'active' => 'نشط',
                'expired' => 'منتهي',
                'cancelled' => 'ملغي',
              ])
              ->default('active')
              ->required()
              ->native(false),
          ])->columnSpanFull(),
      ]);
  }
}
