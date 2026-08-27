<?php

namespace App\Filament\Resources\AccountUpgradeds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AccountUpgradedsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('accountUpgradeRequest.id')
          ->label('رقم الطلب')
          ->formatStateUsing(fn($state) => "طلب #" . $state)
          ->sortable()
          ->weight('bold'),

        TextColumn::make('status')
          ->label('الحالة')
          ->formatStateUsing(fn($state) => match ($state) {
            'active' => 'نشط',
            'expired' => 'منتهي',
            'cancelled' => 'ملغي',
            default => $state,
          })
          ->badge()
          ->color(fn($state) => match ($state) {
            'active' => 'success',
            'expired' => 'danger',
            'cancelled' => 'warning',
            default => 'gray',
          })
          ->sortable(),

        TextColumn::make('start_date')
          ->label('تاريخ البداية')
          ->date('Y-m-d')
          ->sortable(),

        TextColumn::make('end_date')
          ->label('تاريخ النهاية')
          ->date('Y-m-d')
          ->sortable(),

        TextColumn::make('comosion')
          ->label('العمولة')
          ->money('USD')
          ->sortable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        SelectFilter::make('status')
          ->label('الحالة')
          ->options([
            'active' => 'نشط',
            'expired' => 'منتهي',
            'cancelled' => 'ملغي',
          ]),
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
