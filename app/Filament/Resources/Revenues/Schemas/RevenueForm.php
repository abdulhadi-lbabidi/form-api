<?php

namespace App\Filament\Resources\Revenues\Schemas;

use App\Models\CompanyFund;
use App\Models\Fund;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class RevenueForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('اختيار نوع الإيراد والصندوق')
          ->columns(2)
          ->schema([
            // اختيار النوع
            Select::make('fund_type')
              ->label('نوع الإيراد')
              ->options([
                'company' => 'إيراد شركة',
                'user' => 'إيراد مستخدم',
              ])
              ->live()
              ->required()
              ->afterStateUpdated(fn($set) => $set('fund_id', null)),

            // اختيار الصندوق بناءً على النوع
            Select::make('fund_id')
              ->label('الصندوق')
              ->options(function (callable $get) {
                $type = $get('fund_type');
                if ($type === 'company') return CompanyFund::pluck('name', 'id');
                if ($type === 'user') return Fund::with('user')->get()->mapWithKeys(fn($f) => [$f->id => $f->name . ' (' . ($f->user->name ?? 'لا يوجد') . ')']);
                return [];
              })
              ->live()
              ->required()
              ->searchable()
              ->preload()
              ->afterStateUpdated(fn($set) => $set('currency_id', null)),

            // اختيار العملة
            Select::make('currency_id')
              ->label('العملة')
              ->options(function (callable $get) {
                $type = $get('fund_type');
                $fundId = $get('fund_id');
                if (!$fundId) return [];
                $model = ($type === 'company') ? CompanyFund::class : Fund::class;
                $fund = $model::find($fundId);
                return $fund ? $fund->currencies->pluck('name', 'id') : [];
              })
              ->live()
              ->required()
              ->searchable()
              ->preload(),

            // عرض الرصيد الحالي
            Placeholder::make('balance_display')
              ->label('الرصيد الحالي في الصندوق')
              ->content(function (callable $get) {
                $type = $get('fund_type');
                $fundId = $get('fund_id');
                $currencyId = $get('currency_id');

                if (!$fundId || !$currencyId) return 'اختر الصندوق والعملة';

                $model = ($type === 'company') ? CompanyFund::class : Fund::class;
                $fund = $model::find($fundId);
                $pivot = $fund?->currencies()->where('currency_id', $currencyId)->first()?->pivot;

                return new HtmlString('<b style="color: #16a34a;">' . number_format($pivot?->balance ?? 0, 2) . '</b>');
              }),
          ]),

        Section::make('تفاصيل الإيراد')
          ->schema([
            TextInput::make('name')
              ->label('البيان / اسم الإيراد')
              ->required()
              ->maxLength(255),

            TextInput::make('amount')
              ->label('المبلغ')
              ->numeric()
              ->required(),

            Textarea::make('description')->label('ملاحظات'),
          ]),
      ]);
  }
}
