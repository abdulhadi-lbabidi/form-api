<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KadrJobHostingsRelationManager extends RelationManager
{
  protected static string $relationship = 'kadrJobHostings';
  protected static ?string $title = 'عروض وظائف الكوادر التابعة لهذا التصنيف';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('title')
      ->defaultSort('kadr_job_hostings.created_at', 'desc')
      ->columns([
        TextColumn::make('title')
          ->label('عنوان الوظيفة')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('kadr.name')
          ->label('الكادر المسؤول')
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
          ->sortable()
          ->formatStateUsing(fn($state) => $state ? number_format((float) $state, 2) : 'غير محدد')
          ->extraAttributes(['dir' => 'ltr', 'style' => 'text-align: right;']),

        TextColumn::make('salary_max')
          ->label('الحد الأعلى للراتب')
          ->sortable()
          ->formatStateUsing(fn($state) => $state ? number_format((float) $state, 2) : 'غير محدد')
          ->extraAttributes(['dir' => 'ltr', 'style' => 'text-align: right;']),

        TextColumn::make('currency')
          ->label('العملة'),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
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
      ]);
  }
}
