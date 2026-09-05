<?php

namespace App\Filament\Resources\KadrFeedback\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KadrFeedbackTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('kadr.name')
          ->label('الكادر')
          ->searchable()
          ->sortable()
          ->weight('bold')
          ->state(fn($record) => $record->kadr?->name ?? ($record->kadr?->first_name . ' ' . $record->kadr?->last_name)),

        TextColumn::make('stars')
          ->label('النجوم')
          ->numeric()
          ->sortable()
          ->badge()
          ->color('warning')
          ->formatStateUsing(fn($state) => "{$state} ⭐"),

        TextColumn::make('feedbackable_type')
          ->label('الطرف المرتبط')
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'App\Models\Company' => 'شركة',
            'App\Models\Worker'  => 'عامل',
            'App\Models\User'    => 'مستخدم',
            default              => $state,
          })
          ->badge()
          ->color('info')
          ->sortable(),

        TextColumn::make('feedbackable_id')
          ->label('معرف الطرف')
          ->numeric()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),

        TextColumn::make('reason')
          ->label('السبب / الملاحظات')
          ->limit(50)
          ->searchable()
          ->placeholder('لا توجد ملاحظات'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        SelectFilter::make('feedbackable_type')
          ->label('نوع الطرف المرتبط')
          ->options([
            'App\Models\Company' => 'شركة',
            'App\Models\Worker'  => 'عامل',
            'App\Models\User'    => 'مستخدم',
          ]),
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
