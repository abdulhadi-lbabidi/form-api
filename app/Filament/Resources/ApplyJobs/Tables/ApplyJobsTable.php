<?php

namespace App\Filament\Resources\ApplyJobs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ApplyJobsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('worker.full_name')
          ->searchable()
          ->sortable()
          ->label('العامل'),

        TextColumn::make('jobable_type')
          ->formatStateUsing(fn(string $state): string => class_basename($state))
          ->badge()
          ->label('نوع الوظيفة'),

        TextColumn::make('jobable_id')
          ->label('اسم الوظيفة')
          ->formatStateUsing(function ($record) {
            return $record->jobable?->title ?? 'غير متوفرة';
          })
          ->sortable(),

        TextColumn::make('status')
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'pending' => 'warning',
            'accepted' => 'success',
            'rejected' => 'danger',
            default => 'gray',
          })
          ->searchable()
          ->label('الحالة'),

        TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->label('تاريخ التقديم')
          ->toggleable(),

      ])
      ->filters([
        SelectFilter::make('status')
          ->options([
            'pending' => 'قيد الانتظار',
            'accepted' => 'مقبول',
            'rejected' => 'مرفوض',
          ])
          ->label('فلترة حسب الحالة'),
        SelectFilter::make('jobable_type')
          ->options([
            'App\Models\CompanyJobHosting' => 'وظيفة شركة',
            'App\Models\KadrJobHosting' => 'وظيفة كادر',
          ])
          ->label('فلترة حسب نوع الوظيفة'),
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
