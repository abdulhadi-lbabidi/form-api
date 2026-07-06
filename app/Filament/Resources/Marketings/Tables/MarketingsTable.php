<?php

namespace App\Filament\Resources\Marketings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MarketingsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('id')
          ->label('ID')
          ->sortable()
          ->fontFamily('mono'),

        TextColumn::make('translated_name')
          ->label('اسم المصدر')
          ->searchable(query: function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
          })
          ->weight('bold'),

        TextColumn::make('workers_count')
          ->label('العمال المسجلين')
          ->counts('workers')
          ->badge()
          ->color('success')
          ->alignCenter(),

        TextColumn::make('companies_count')
          ->label('الشركات المسجلة')
          ->counts('companies')
          ->badge()
          ->color('info')
          ->alignCenter(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
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
