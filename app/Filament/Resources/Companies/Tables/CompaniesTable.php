<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompaniesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('company_name')
          ->label('اسم الشركة')
          ->searchable()
          ->sortable(),

        TextColumn::make('business_type')
          ->label('نوع العمل')
          ->searchable()
          ->toggleable(),

        TextColumn::make('owner_name')
          ->label('المالك')
          ->searchable(),

        TextColumn::make('work_location')
          ->label('الموقع')
          ->searchable(),

        TextColumn::make('email')
          ->label('البريد الإلكتروني')
          ->searchable(),

        TextColumn::make('phone_number')
          ->label('رقم الهاتف')
          ->searchable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable()
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
