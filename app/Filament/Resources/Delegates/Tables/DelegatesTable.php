<?php

namespace App\Filament\Resources\Delegates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DelegatesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('user.name')
          ->label('المندوب')
          ->searchable()
          ->sortable(),

        TextColumn::make('user.phone_number')
          ->label('رقم الهاتف')
          ->searchable()
          ->placeholder('-'),

        TextColumn::make('address')
          ->label('عنوان السكن')
          ->searchable()
          ->limit(30),

        TextColumn::make('fixed_salary')
          ->label('الراتب الثابت')
          ->sortable(),

        TextColumn::make('commission_rate')
          ->label('العمولة')
          ->sortable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime()
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
