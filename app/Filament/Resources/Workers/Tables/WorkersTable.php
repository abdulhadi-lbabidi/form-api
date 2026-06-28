<?php

namespace App\Filament\Resources\Workers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkersTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('first_name')
          ->label('الاسم الأول')
          ->searchable()
          ->sortable(),

        TextColumn::make('last_name')
          ->label('الكنية')
          ->searchable()
          ->sortable(),

        TextColumn::make('phone_whatsapp')
          ->label('رقم الهاتف')
          ->searchable(),

        TextColumn::make('city')
          ->label('المدينة')
          ->searchable(),

        TextColumn::make('primary_profession')
          ->label('المهنة')
          ->searchable(),

        TextColumn::make('expected_hourly_rate')
          ->label('أجر الساعة')
          ->prefix('$')
          ->sortable(),

        TextColumn::make('payment_method')
          ->label('طريقة الدفع')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'weekly' => 'warning',
            'monthly' => 'success',
            default => 'gray',
          })
          ->formatStateUsing(fn($state) => $state === 'weekly' ? 'أسبوعي' : 'شهري'),

        TextColumn::make('created_at')
          ->label('تاريخ التسجيل')
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
