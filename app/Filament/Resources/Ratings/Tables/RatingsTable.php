<?php

namespace App\Filament\Resources\Ratings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RatingsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        IconColumn::make('is_verified')
          ->label('التحقق')
          ->boolean()
          ->trueIcon('heroicon-m-check-circle')
          ->falseIcon('heroicon-m-x-circle')
          ->trueColor('success')
          ->falseColor('danger'),

        TextColumn::make('worker.full_name')
          ->label('العامل')
          ->searchable(query: function ($query, string $search) {
            $query->whereHas('worker', function ($q) use ($search) {
              $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
          })
          ->state(fn($record) => $record->worker ? "{$record->worker->first_name} {$record->worker->last_name}" : '-')
          ->weight('bold'),

        TextColumn::make('user.name')
          ->label('المُقيِّم')
          ->searchable(),

        TextColumn::make('seriousness_level')
          ->label('الجدية')
          ->sortable()
          ->alignCenter()
          ->formatStateUsing(fn($state) => "⭐ {$state}"),

        TextColumn::make('skill_level')
          ->label('المهارة')
          ->sortable()
          ->alignCenter()
          ->formatStateUsing(fn($state) => "⭐ {$state}"),

        TextColumn::make('communication_level')
          ->label('التواصل')
          ->sortable()
          ->alignCenter()
          ->formatStateUsing(fn($state) => "⭐ {$state}"),

        TextColumn::make('skill_matching')
          ->label('تطابق المهارة')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'matched' => 'success',
            'partially_matched' => 'warning',
            'not_matched' => 'danger',
            default => 'gray',
          })
          ->formatStateUsing(fn($state) => match ($state) {
            'matched' => 'متطابق',
            'partially_matched' => 'جزئي',
            'not_matched' => 'غير متطابق',
            default => $state
          }),

        TextColumn::make('created_at')
          ->label('تاريخ التقييم')
          ->dateTime('Y-m-d')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        TernaryFilter::make('is_verified')
          ->label('حالة التحقق من التقييم')
          ->placeholder('الكل')
          ->trueLabel('التقييمات المتحقق منها')
          ->falseLabel('التقييمات المنتظرة للتحقق'),
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
