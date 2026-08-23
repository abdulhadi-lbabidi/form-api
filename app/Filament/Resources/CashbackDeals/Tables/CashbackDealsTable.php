<?php

namespace App\Filament\Resources\CashbackDeals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CashbackDealsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        SpatieMediaLibraryImageColumn::make('images_content_deals')
          ->label('الصورة')
          ->collection('cashback-deals')
          ->circular(),

        TextColumn::make('title')
          ->label('عنوان العرض')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('cashback.company_name')
          ->label('الإعلان الترويجي')
          ->searchable()
          ->sortable()
          ->badge()
          ->color('info'),

        TextColumn::make('status')
          ->label('الحالة')
          ->badge()
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'active'   => 'نشط',
            'inactive' => 'غير نشط',
            'expired'  => 'منتهي',
            default    => $state,
          })
          ->color(fn(string $state): string => match ($state) {
            'active'   => 'success',
            'inactive' => 'warning',
            'expired'  => 'danger',
            default    => 'gray',
          })
          ->sortable(),

        TextColumn::make('comosion')
          ->label('العمولة')
          ->formatStateUsing(fn($state) => number_format((float) $state, 2))
          ->weight('bold')
          ->color('success')
          ->sortable(),

        TextColumn::make('start_date')
          ->label('البداية')
          ->date('Y-m-d')
          ->sortable(),

        TextColumn::make('end_date')
          ->label('النهاية')
          ->date('Y-m-d')
          ->sortable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        SelectFilter::make('cashback_id')
          ->label('الإعلان الترويجي')
          ->relationship('cashback', 'company_name')
          ->searchable()
          ->preload(),


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
