<?php

namespace App\Filament\Resources\Kadrs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KadrsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('name')
          ->label('الاسم')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('number_of_person')
          ->label('الرقم')
          ->searchable()
          ->sortable(),

        TextColumn::make('phone')
          ->label('رقم الهاتف')
          ->searchable()
          ->icon('heroicon-m-phone')
          ->copyable()
          ->url(fn($record) => "tel:{$record->phone}"),

        TextColumn::make('email')
          ->label('البريد الإلكتروني')
          ->searchable()
          ->placeholder('لا يوجد')
          ->copyable(),

        TextColumn::make('city')
          ->label('المدينة')
          ->searchable()
          ->color('primary'),

        TextColumn::make('shop_address')
          ->label('عنوان المحل')
          ->searchable()
          ->toggleable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable(),
      ])
      ->filters([
        // يمكنك إضافة مرشحات هنا عند الحاجة
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->headerActions([])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
