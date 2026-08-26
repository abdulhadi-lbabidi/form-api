<?php

namespace App\Filament\Resources\CashbackCounters\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackCounterForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('معلومات عداد الصفقة')
          ->description('اختر صفقة الكاش باك والجهة المرتبطة بالعداد.')
          ->icon('heroicon-o-chart-bar')
          ->schema([
            Select::make('cashback_deal_id')
              ->label('صفقة الكاش باك')
              ->relationship('cashbackDeal', 'title')
              ->required()
              ->searchable()
              ->preload()
              ->columnSpanFull(),

            Select::make('counterable_type')
              ->label('نوع الجهة المرتبطة')
              ->options([
                'App\Models\Company' => 'شركة (Company)',
                'App\Models\Worker'  => 'عامل (Worker)',
                'App\Models\Kadr'    => 'كادر (Kadr)',
              ])
              ->required()
              ->live()
              ->afterStateUpdated(fn(callable $set) => $set('counterable_id', null)),

            Select::make('counterable_id')
              ->label('الجهة المرتبطة')
              ->options(function (callable $get) {
                $type = $get('counterable_type');
                if (!$type || !class_exists($type)) {
                  return [];
                }

                $labelField = match ($type) {
                  'App\Models\Company' => 'company_name',
                  'App\Models\Worker'  => 'full_name',
                  'App\Models\Kadr'    => 'name',
                  default              => 'id',
                };

                return $type::pluck($labelField, 'id');
              })
              ->required()
              ->searchable()
              ->preload(),
          ])->columnSpanFull(),
      ]);
  }
}
