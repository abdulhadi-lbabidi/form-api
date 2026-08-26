<?php

namespace App\Filament\Resources\CompanyJobHostings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompanyJobHostingsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('title')
          ->label('عنوان الوظيفة')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('company.company_name')
          ->label('الشركة المعلنة')
          ->searchable()
          ->sortable()
          ->placeholder('غير محدد'),

        TextColumn::make('status')
          ->label('الحالة')
          ->badge()
          ->sortable()
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'pending'  => 'قيد المراجعة',
            'approved' => 'نشط',
            'rejected' => 'مرفوض',
            'closed'   => 'مغلق',
            default    => $state,
          })
          ->color(fn(string $state): string => match ($state) {
            'pending'  => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'closed'   => 'gray',
            default    => 'gray',
          }),

        TextColumn::make('job_type')
          ->label('نوع الدوام')
          ->badge()
          ->color('info')
          ->searchable(),

        TextColumn::make('workers_count')
          ->label('العدد')
          ->sortable()
          ->alignment('center'),

        TextColumn::make('city')
          ->label('المدينة')
          ->searchable()
          ->color('primary'),

        TextColumn::make('salary_min')
          ->label('الأجر الأدنى')
          ->numeric()
          ->sortable(),

        TextColumn::make('currency')
          ->label('العملة'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum;']),
      ])
      ->filters([
        SelectFilter::make('status')
          ->label('حالة الشاغر')
          ->options([
            'pending'  => 'قيد المراجعة',
            'approved' => 'نشط',
            'rejected' => 'مرفوض',
            'closed'   => 'مغلق',
          ]),
        SelectFilter::make('job_type')
          ->label('نوع الدوام')
          ->options([
            'دوام كامل' => 'دوام كامل',
            'دوام جزئي' => 'دوام جزئي',
            'مياومة'    => 'مياومة',
            'عقد مؤقت' => 'عقد مؤقت',
          ]),
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
