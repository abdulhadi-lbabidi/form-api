<?php

namespace App\Filament\Resources\FailedRegistrationAttempts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FailedRegistrationAttemptsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('target_type')
          ->label('نوع الجهة')
          ->badge()
          ->color(fn($state) => match ($state) {
            'worker' => 'info',
            'kadr' => 'success',
            'company' => 'warning',
            default => 'gray',
          })
          ->searchable()
          ->sortable(),
          
        TextColumn::make('phone')
          ->label('رقم الهاتف')
          ->searchable()
          ->sortable()
          ->placeholder('-'),

        TextColumn::make('ip_address')
          ->label('عنوان IP')
          ->searchable()
          ->sortable()
          ->placeholder('-'),

        TextColumn::make('platform')
          ->label('المنصة')
          ->searchable()
          ->placeholder('-'),

        TextColumn::make('browser')
          ->label('المتصفح')
          ->searchable()
          ->placeholder('-'),

        TextColumn::make('created_at')
          ->label('وقت المحاولة')
          ->dateTime('Y-m-d H:i')
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        ViewAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}