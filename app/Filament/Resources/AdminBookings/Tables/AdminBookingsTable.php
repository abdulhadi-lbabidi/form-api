<?php

namespace App\Filament\Resources\AdminBookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminBookingsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('booking_date', 'desc')
      ->columns([
        TextColumn::make('user.name')
          ->label('المسؤول')
          ->searchable()
          ->sortable(),

        TextColumn::make('interviewer.name')
          ->label('المقابل')
          ->searchable()
          ->sortable()
          ->placeholder('—'),

        TextColumn::make('booking_date')
          ->label('تاريخ الحجز')
          ->date('Y-m-d')
          ->sortable()
          ->searchable()
          ->icon('heroicon-m-calendar-days')
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: sans-serif;']),

        TextColumn::make('time_from')
          ->label('من')
          ->time('H:i')
          ->sortable(),

        TextColumn::make('time_to')
          ->label('إلى')
          ->time('H:i')
          ->sortable(),

        TextColumn::make('companies_count')
          ->label('عدد الشركات')
          ->counts('companies')
          ->color('info')
          ->sortable(),

        TextColumn::make('workers_count')
          ->label('عدد العمال')
          ->counts('workers')
          ->color('success')
          ->sortable(),

        TextColumn::make('status')
          ->label('الحالة')
          ->badge()
          ->colors([
            'warning' => 'pending',
            'success' => ['active', 'completed'],
            'danger' => 'canceled',
          ])
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'pending' => 'قيد الانتظار',
            'active' => 'نشط',
            'canceled' => 'ملغي',
            'completed' => 'تمت المقابلة',
            default => $state,
          })
          ->sortable()
          ->searchable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
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
