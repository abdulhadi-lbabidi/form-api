<?php

namespace App\Filament\Resources\ReferralCodes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
          ->fontFamily('mono')
          ->copyable()
          ->copyMessage('تم نسخ كود الإحالة بنجاح')
          ->icon('heroicon-m-clipboard-document-check')
          ->color('primary'),

        TextColumn::make('referralable_type')
          ->label('نوع المستفيد')
          ->badge()
          ->formatStateUsing(fn($state) => $state === 'App\Models\Company' ? 'شركة' : 'عامل')
          ->color(fn($state) => $state === 'App\Models\Company' ? 'info' : 'purple'),

        TextColumn::make('owner_name')
          ->label('اسم صاحب الكود')
          ->icon('heroicon-m-user')
          ->state(function ($record) {
            return $record->referralable?->company_name
              ?? ($record->referralable ? "{$record->referralable->first_name} {$record->referralable->last_name}" : '-');
          }),

        TextColumn::make('times_used')
          ->label('الاستخدام / الحد')
          ->sortable()
          ->state(function ($record) {
            $limit = $record->usage_limit ?? '∞';
            return "{$record->times_used} / {$limit}";
          })
          ->color(fn($record) => $record->usage_limit && $record->times_used >= $record->usage_limit ? 'danger' : 'gray')
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; font-weight: 500;']),

        TextColumn::make('expires_at')
          ->label('تاريخ الانتهاء')
          ->dateTime('Y-m-d')
          ->sortable()
          ->placeholder('مفتوح')
          ->icon('heroicon-m-calendar')
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

        IconColumn::make('is_active')
          ->label('حالة الكود')
          ->boolean()
          ->sortable(),
      ])
      ->filters([
        SelectFilter::make('referralable_type')
          ->label('تصفية حسب نوع المستفيد')
          ->options([
            'App\Models\Company' => 'الشركات فقط',
            'App\Models\Worker' => 'العمال فقط',
          ]),
        SelectFilter::make('is_active')
          ->label('حالة الكود')
          ->options([
            '1' => 'الأكواد النشطة فقط',
            '0' => 'الأكواد غير النشطة',
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
