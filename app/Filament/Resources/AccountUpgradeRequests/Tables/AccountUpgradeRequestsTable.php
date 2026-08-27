<?php

namespace App\Filament\Resources\AccountUpgradeRequests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AccountUpgradeRequestsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('morphable_type')
          ->label('نوع الجهة')
          ->formatStateUsing(fn($state) => match ($state) {
            'App\Models\Company' => 'شركة',
            'App\Models\Worker'  => 'عامل',
            'App\Models\Kadr'    => 'كادر',
            default              => $state,
          })
          ->badge()
          ->color('warning')
          ->sortable(),

        TextColumn::make('morphable')
          ->label('اسم الجهة')
          ->getStateUsing(function ($record) {
            if (!$record->morphable) return 'غير متوفر';

            return match (get_class($record->morphable)) {
              'App\Models\Company' => $record->morphable->company_name ?? 'شركة #' . $record->morphable->id,
              'App\Models\Worker'  => $record->morphable->full_name ?? 'عامل #' . $record->morphable->id,
              'App\Models\Kadr'    => $record->morphable->name ?? 'كادر #' . $record->morphable->id,
              default              => 'معرف #' . $record->morphable->id,
            };
          })
          ->badge()
          ->color('success'),

        TextColumn::make('status')
          ->label('الحالة')
          ->formatStateUsing(fn($state) => match ($state) {
            'pending'   => 'قيد الانتظار',
            'approved'  => 'تم الموافقة',
            'rejected'  => 'مرفوض',
            default     => $state,
          })
          ->badge()
          ->color(fn($state) => match ($state) {
            'approved'  => 'success',
            'pending'   => 'warning',
            'rejected'  => 'danger',
            default     => 'gray',
          })
          ->sortable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d H:i')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        SelectFilter::make('status')
          ->label('حالة الطلب')
          ->options([
            'pending'   => 'قيد الانتظار',
            'approved'  => 'تم الموافقة',
            'rejected'  => 'مرفوض',
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
