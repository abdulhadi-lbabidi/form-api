<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class KadrsRelationManager extends RelationManager
{
  protected static string $relationship = 'kadrs';
  protected static ?string $title = 'الكوادر التابعون لهذا التصنيف';

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('name')
      ->defaultSort('kadrs.created_at', 'desc')
      ->columns([
        TextColumn::make('name')
          ->label('الاسم الكامل')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('first_name')
          ->label('الاسم الأول')
          ->searchable()
          ->toggleable(),

        TextColumn::make('father_name')
          ->label('اسم الأب')
          ->searchable()
          ->toggleable(isToggledHiddenByDefault: true),

        TextColumn::make('last_name')
          ->label('العائلة')
          ->searchable()
          ->toggleable(),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

        TextColumn::make('phone')
          ->label('رقم الهاتف')
          ->searchable()
          ->icon('heroicon-m-phone')
          ->copyable()
          ->url(fn($record) => "tel:{$record->phone}")
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

        TextColumn::make('service_type')
          ->label('نوع الخدمة')
          ->searchable()
          ->badge()
          ->color('success')
          ->placeholder('غير مسجل'),

        IconColumn::make('has_team')
          ->label('فريق عمل')
          ->boolean()
          ->sortable(),

        TextColumn::make('number_of_person')
          ->label('عدد الأفراد')
          ->sortable()
          ->placeholder('لا يوجد'),

        TextColumn::make('city')
          ->label('المدينة')
          ->searchable()
          ->sortable()
          ->color('primary'),

        TextColumn::make('residential_area')
          ->label('المنطقة / الحي')
          ->searchable()
          ->toggleable(),

        TextColumn::make('shop_address')
          ->label('عنوان العمل')
          ->searchable()
          ->toggleable(isToggledHiddenByDefault: true),

        TextColumn::make('email')
          ->label('البريد الإلكتروني')
          ->searchable()
          ->placeholder('لا يوجد')
          ->copyable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        TernaryFilter::make('has_team')
          ->label('حالة الفريق')
          ->placeholder('الكل')
          ->trueLabel('يملكون فريق عمل')
          ->falseLabel('بدون فريق'),
      ]);
  }
}
