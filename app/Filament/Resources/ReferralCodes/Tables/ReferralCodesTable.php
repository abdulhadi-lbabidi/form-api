<?php

namespace App\Filament\Resources\ReferralCodes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReferralCodesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('code')
          ->label('الكود')
          ->searchable()
          ->sortable()
          ->weight('bold')
          ->copyable(),

        TextColumn::make('referralable_type')
          ->label('نوع المستفيد')
          ->formatStateUsing(fn($state) => $state === 'App\Models\Company' ? 'شركة' : 'عامل'),

        TextColumn::make('owner_name')
          ->label('اسم صاحب الكود')
          ->state(function ($record) {
            return $record->referralable?->company_name
              ?? ($record->referralable ? "{$record->referralable->first_name} {$record->referralable->last_name}" : '-');
          }),

        TextColumn::make('usage_limit')
          ->label('الحد')
          ->sortable()
          ->placeholder('∞'),

        TextColumn::make('times_used')
          ->label('عدد مرات الاستخدام')
          ->sortable(),

        TextColumn::make('expires_at')
          ->label('تاريخ الانتهاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->placeholder('مفتوح'),

        IconColumn::make('is_active')
          ->label('نشط')
          ->boolean(),
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
