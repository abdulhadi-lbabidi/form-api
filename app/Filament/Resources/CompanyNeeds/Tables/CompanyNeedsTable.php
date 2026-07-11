<?php

namespace App\Filament\Resources\CompanyNeeds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyNeedsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('branch.company.company_name')
          ->label('الشركة')
          ->searchable()
          ->sortable()
          ->color('gray'),

        TextColumn::make('branch.branch_name')
          ->label('الفرع')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('required_profession')
          ->label('الصنعة المطلوبة')
          ->searchable()
          ->badge()
          ->color('warning'),

        TextColumn::make('required_workers_count')
          ->label('العدد')
          ->sortable()
          ->alignCenter()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-weight: bold;']),

        TextColumn::make('needed_at')
          ->label('متى؟')
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'today' => 'اليوم',
            'this_week' => 'خلال أسبوع',
            'this_month' => 'خلال شهر',
            'not_specified_yet' => 'غير محدد بعد',
            default => $state,
          }),

        TextColumn::make('employment_type')
          ->label('نوع الدوام')
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'full_time' => 'دوام كامل',
            'part_time' => 'دوام جزئي',
            'daily_wage' => 'مياومة',
            default => $state,
          }),

        TextColumn::make('offered_salary')
          ->label('الأجر')
          ->placeholder('غير محدد')
          ->state(function ($record) {
            return $record->offered_salary
              ? number_format($record->offered_salary) . ' ' . ($record->currency === 'USD' ? 'دولار' : 'ليرة')
              : null;
          })
          ->color('success')
          ->extraAttributes(['style' => 'font-variant-numeric: lnum;']),
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
