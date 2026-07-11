<?php

namespace App\Filament\Resources\CompanyBranches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyBranchesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('company.company_name')
          ->label('الشركة ')
          ->searchable()
          ->sortable()
          ->weight('bold')
          ->color('primary'),

        TextColumn::make('branch_name')
          ->label('اسم الفرع')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('location_address')
          ->label('الموقع التفصيلي')
          ->searchable()
          ->icon('heroicon-m-map-pin')
          ->placeholder('غير محدد'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true)
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
