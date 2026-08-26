<?php

namespace App\Filament\Resources\Cashbacks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CashbacksTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('company_name')
          ->label('اسم الشركة')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('reasone')
          ->label('السبب')
          ->placeholder('لا يوجد')
          ->searchable()
          ->sortable(),

        ToggleColumn::make('is_favorite')
          ->label('المفضلة')
          ->sortable(),

        TextColumn::make('redirect_url')
          ->label('رابط التوجيه')
          ->url(fn($record) => $record->redirect_url)
          ->openUrlInNewTab()
          ->color('primary')
          ->placeholder('لا يوجد')
          ->limit(30)
          ->searchable(),

        TextColumn::make('number_of_clicks')
          ->label('عدد النقرات')
          ->numeric()
          ->sortable()
          ->badge()
          ->color('success'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        TernaryFilter::make('is_favorite')
          ->label('حالة المفضلة')
          ->trueLabel('المفضلة فقط')
          ->falseLabel('غير المفضلة فقط')
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
