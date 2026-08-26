<?php

namespace App\Filament\Resources\Cashbacks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashbacksTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('company_name')
          ->label('اسم الشركة')
          ->searchable()
          ->sortable()
          ->weight('bold'),


        TextColumn::make('owner_name')
          ->label('اسم المالك')
          ->searchable()
          ->sortable()
          ->placeholder('لا يوجد'),

        TextColumn::make('phone_number')
          ->label('رقم الهاتف')
          ->searchable()
          ->placeholder('لا يوجد'),


        TextColumn::make('reasone')
          ->label('السبب')
          ->placeholder('لا يوجد')
          ->searchable()
          ->sortable(),

        TextColumn::make('cashbackable_type')
          ->label('نوع الجهة')
          ->formatStateUsing(function ($state) {
            return match ($state) {
              'App\Models\Company' => 'شركة',
              'App\Models\Worker'  => 'عامل',
              'App\Models\Kadr'    => 'كادر',
              default              => $state,
            };
          })
          ->badge()
          ->color('warning')
          ->sortable(),

        TextColumn::make('cashbackable')
          ->label('اسم الجهة')
          ->getStateUsing(function ($record) {
            if (!$record->cashbackable) return 'غير متوفر';

            return match (get_class($record->cashbackable)) {
              'App\Models\Company' => $record->cashbackable->company_name ?? 'شركة #' . $record->cashbackable->id,
              'App\Models\Worker'  => $record->cashbackable->full_name ?? 'عامل #' . $record->cashbackable->id,
              'App\Models\Kadr'    => $record->cashbackable->name ?? 'كادر #' . $record->cashbackable->id,
              default              => 'معرف #' . $record->cashbackable->id,
            };
          })
          ->badge()
          ->color('success'),

        TextColumn::make('redirect_url')
          ->label('رابط التوجيه')
          ->url(fn($record) => $record->redirect_url)
          ->openUrlInNewTab()
          ->color('primary')
          ->placeholder('لا يوجد')
          ->limit(30)
          ->searchable(),

        TextColumn::make('number_of_clicks')
          ->label('عدد النقرات')
          ->numeric()
          ->sortable()
          ->badge()
          ->color('success'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
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
