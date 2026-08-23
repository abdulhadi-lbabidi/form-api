<?php

namespace App\Filament\Resources\Revenues\Tables;

use App\Models\CompanyFund;
use App\Models\Fund;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RevenuesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('name')
          ->label('اسم الإيراد')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        // عرض اسم الصندوق التابع له الإيراد
        TextColumn::make('fundable.name')
          ->label('الصندوق')
          ->searchable()
          ->sortable()
          ->badge()
          ->color('info'),

        TextColumn::make('amount')
          ->label('المبلغ')
          ->formatStateUsing(fn($state) => number_format((float) $state, 2, '.', ''))
          ->weight('bold')
          ->extraAttributes([
            'style' => 'direction: ltr; text-align: right;',
          ])
          ->sortable()
          ->color('success'),

        // عرض عملة الإيراد
        TextColumn::make('currency.name')
          ->label('العملة')
          ->badge()
          ->sortable(),

        TextColumn::make('creator.name')
          ->label('أُضيف بواسطة')
          ->placeholder('النظام')
          ->searchable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        // فلتر حسب العملة
        SelectFilter::make('currency_id')
          ->label('العملة')
          ->relationship('currency', 'name')
          ->searchable()
          ->preload(),

        // فلتر حسب نوع الصندوق (شركة أو مستخدم)
        SelectFilter::make('fundable_type')
          ->label('نوع الصندوق')
          ->options([
            CompanyFund::class => 'صندوق شركة',
            Fund::class => 'صندوق مستخدم',
          ])
          ->query(function ($query, array $state) {
            if (!empty($state['value'])) {
              $query->where('fundable_type', $state['value']);
            }
          }),
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
