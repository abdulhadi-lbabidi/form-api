<?php

namespace App\Filament\Resources\Subscriptions\Tables;

use App\Models\Company;
use App\Models\Worker;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('subscribable')
          ->label('المشترك')
          ->state(function ($record) {
            if (!$record->subscribable) return '—';

            if ($record->subscribable_type === Company::class) {
              return "🏢 " . $record->subscribable->company_name;
            }

            if ($record->subscribable_type === Worker::class) {
              return "👤 " . $record->subscribable->first_name . ' ' . $record->subscribable->last_name;
            }

            return '—';
          })
          ->searchable(query: function ($query, string $search) {
            $query->whereHasMorph('subscribable', [Company::class, Worker::class], function ($q, $type) use ($search) {
              if ($type === Company::class) {
                $q->where('company_name', 'like', "%{$search}%");
              }
              if ($type === Worker::class) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
              }
            });
          }),

        TextColumn::make('time.work_time')
          ->label('الفترة الزمنية')
          ->searchable()
          ->sortable(),
        TextColumn::make('status')
          ->label('حالة الاشتراك')
          ->searchable()
          ->badge()
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'pending' => 'قيد الانتظار',
            'active' => 'نشط',
            'canceled' => 'ملغي',
            default => $state,
          })
          ->color(fn(string $state): string => match ($state) {
            'active' => 'success',
            'pending' => 'warning',
            'canceled' => 'danger',
            default => 'gray',
          }),

        TextColumn::make('created_at')
          ->label('تاريخ الإنشاء')
          ->dateTime('Y-m-d')
          ->sortable(),


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
