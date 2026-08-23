<?php

namespace App\Filament\Resources\CashbackCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashbackCategoriesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('name')
          ->label('اسم التصنيف')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('description')
          ->label('الوصف')
          ->placeholder('لا يوجد وصف')
          ->limit(50)
          ->searchable(),

        TextColumn::make('cashbacks_count')
          ->label('عدد الإعلانات')
          ->counts('cashbacks')
          ->badge()
          ->color('success')
          ->sortable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
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
