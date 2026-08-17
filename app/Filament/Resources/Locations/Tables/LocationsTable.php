<?php

namespace App\Filament\Resources\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LocationsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('id')
          ->label('#')
          ->sortable(),

        TextColumn::make('name')
          ->label('اسم المنطقة')
          ->searchable()
          ->sortable()
          ->weight('bold')
          ->color('primary'),

        TextColumn::make('coordinates')
          ->label('الإحداثيات المسجلة')
          ->formatStateUsing(fn($state) => count($state ?? []) . ' نقاط إحداثيات مسجلة')
          ->badge()
          ->color('success'),

        TextColumn::make('created_at')
          ->label('تاريخ الإضافة')
          ->dateTime('Y-m-d')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([])
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
