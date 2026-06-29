<?php

namespace App\Filament\Resources\Subscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('time.work_time')
          ->label('الفترة الزمنية')
          ->searchable()
          ->sortable(),
        TextColumn::make('status')
          ->label('حالة الاشتراك')
          ->searchable()
          ->badge()
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'pending' => 'قيد الانتظار',
            'active' => 'نشط',
            'canceled' => 'ملغي',
            default => $state,
          })
          ->color(fn(string $state): string => match ($state) {
            'active' => 'success',
            'pending' => 'warning',
            'canceled' => 'danger',
            default => 'gray',
          }),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable(),


      ])
      ->filters([
        //
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
