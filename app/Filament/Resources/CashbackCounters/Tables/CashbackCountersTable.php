<?php

namespace App\Filament\Resources\CashbackCounters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CashbackCountersTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('cashbackDeal.title')
          ->label('صفقة الكاش باك')
          ->searchable()
          ->sortable()
          ->weight('bold')
          ->limit(40),

        TextColumn::make('counterable_type')
          ->label('نوع الجهة')
          ->formatStateUsing(function ($state) {
            return match ($state) {
              'App\Models\Company' => 'شركة',
              'App\Models\Worker'  => 'عامل',
              'App\Models\Kadr'    => 'كادر',
              default              => $state,
            };
          })
          ->badge()
          ->color('warning')
          ->sortable(),

        TextColumn::make('counterable')
          ->label('اسم الجهة المرتبطة')
          ->getStateUsing(function ($record) {
            if (!$record->counterable) return 'غير متوفر';

            return match (get_class($record->counterable)) {
              'App\Models\Company' => $record->counterable->company_name ?? 'شركة #' . $record->counterable->id,
              'App\Models\Worker'  => $record->counterable->full_name ?? 'عامل #' . $record->counterable->id,
              'App\Models\Kadr'    => $record->counterable->name ?? 'كادر #' . $record->counterable->id,
              default              => 'معرف #' . $record->counterable->id,
            };
          })
          ->badge()
          ->color('success'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        SelectFilter::make('cashback_deal_id')
          ->label('صفقة الكاش باك')
          ->relationship('cashbackDeal', 'title')
          ->searchable()
          ->preload(),

        SelectFilter::make('counterable_type')
          ->label('نوع الجهة')
          ->options([
            'App\Models\Company' => 'شركة',
            'App\Models\Worker'  => 'عامل',
            'App\Models\Kadr'    => 'كادر',
          ])
          ->native(false),
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
