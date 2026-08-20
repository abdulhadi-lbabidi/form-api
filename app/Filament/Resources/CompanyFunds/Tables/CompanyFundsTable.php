<?php

namespace App\Filament\Resources\CompanyFunds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyFundsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('name')
          ->label('اسم صندوق الشركة')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum;']),
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
