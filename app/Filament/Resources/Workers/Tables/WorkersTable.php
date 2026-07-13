<?php

namespace App\Filament\Resources\Workers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class WorkersTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        IconColumn::make('is_verified')
          ->label('التوثيق')
          ->boolean()
          ->trueIcon('heroicon-m-check-circle')
          ->falseIcon('heroicon-m-x-circle')
          ->trueColor('success')
          ->falseColor('danger'),

        TextColumn::make('code')
          ->label('رمز العامل')
          ->searchable()
          ->sortable()
          ->placeholder('غير موثق بعد')
          ->weight('bold')
          ->fontFamily('mono')
          ->color('warning'),


        TextColumn::make('full_name')
          ->label('الاسم الكامل')
          ->placeholder(' لا يوجد')
          ->sortable(['full_name'])
          ->searchable()
          ->weight('bold'),

        TextColumn::make('phone_whatsapp')
          ->label('رقم الهاتف / واتساب')
          ->searchable()
          ->placeholder(' لا يوجد')
          ->copyMessage('تم نسخ رقم الهاتف')
          ->url(fn($record) => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->phone_whatsapp), shouldOpenInNewTab: true)
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

        TextColumn::make('city')
          ->label('المدينة')
          ->searchable()
          ->placeholder(' لا يوجد')
          ->color('primary'),

        TextColumn::make('residential_area')
          ->label('المنطقة / السكن')
          ->searchable()
          ->placeholder(' لا يوجد')
          ->color('primary'),

        TextColumn::make('primary_profession')
          ->label('المهنة')
          ->searchable()
          ->placeholder(' لا يوجد')
          ->color('gray'),

        TextColumn::make('expected_hourly_rate_usd')
          ->label('أجر الساعة')
          ->sortable()
          ->placeholder(' لا يوجد')
          ->weight('medium')
          ->formatStateUsing(fn($record) => "$ {$record->expected_hourly_rate_usd} / {$record->expected_hourly_rate_syp} ل.س")
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; color: #10b981;']),

        TextColumn::make('form_referral_code')
          ->label('كود الإحالة المُستخدَم')
          ->placeholder(' لا يوجد')
          ->searchable()
          ->placeholder('لا يوجد')
          ->toggleable(isToggledHiddenByDefault: true),



        TextColumn::make('payment_method')
          ->label('طريقة الدفع')
          ->color(fn(string $state): string => match ($state) {
            'weekly' => 'warning',
            'monthly' => 'success',
            default => 'gray',
          })
          ->formatStateUsing(fn($state) => $state === 'weekly' ? 'أسبوعي' : 'شهري'),

        TextColumn::make('created_at')
          ->label('تاريخ التسجيل')
          ->dateTime('Y-m-d')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true)
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
      ])
      ->filters([
        TernaryFilter::make('is_verified')
          ->label('حالة التوثيق')
          ->placeholder('الكل')
          ->trueLabel('العمال الموثقين')
          ->falseLabel('العمال غير الموثقين'),

        SelectFilter::make('payment_method')
          ->label('طريقة الدفع')
          ->placeholder('الكل')
          ->options([
            'weekly' => 'أسبوعي',
            'monthly' => 'شهري',
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
