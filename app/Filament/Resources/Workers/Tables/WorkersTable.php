<?php

namespace App\Filament\Resources\Workers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WorkersTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('full_name')
          ->label('الاسم الكامل')
          ->searchable(query: function ($query, string $search) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
          })
          ->sortable(['first_name'])
          ->weight('bold')
          ->state(fn($record) => "{$record->first_name} {$record->last_name}"),

        TextColumn::make('phone_whatsapp')
          ->label('رقم الهاتف / واتساب')
          ->searchable()
          ->icon('heroicon-m-phone')
          ->copyable()
          ->copyMessage('تم نسخ رقم الهاتف')
          ->url(fn($record) => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->phone_whatsapp), shouldOpenInNewTab: true)
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

        TextColumn::make('city')
          ->label('المدينة')
          ->searchable()
          ->icon('heroicon-m-map-pin')
          ->color('primary'),

        TextColumn::make('primary_profession')
          ->label('المهنة')
          ->searchable()
          ->icon('heroicon-m-briefcase')
          ->badge()
          ->color('gray'),

        TextColumn::make('expected_hourly_rate')
          ->label('أجر الساعة')
          ->sortable()
          ->weight('medium')
          ->formatStateUsing(
            fn($record) => $record->currency === 'USD'
              ? "$ {$record->expected_hourly_rate}"
              : "{$record->expected_hourly_rate} ل.س"
          )
          ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; color: #10b981;']),

        TextColumn::make('payment_method')
          ->label('طريقة الدفع')
          ->badge()
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
        SelectFilter::make('currency')
          ->label('العملة')
          ->options([
            'SYP' => 'ليرة سورية',
            'USD' => 'دولار أمريكي',
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
