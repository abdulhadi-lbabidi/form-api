<?php

namespace App\Filament\Resources\Notifications\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class NotificationsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('notifiable.name')
          ->label('المستلم')
          ->searchable()
          ->sortable()
          ->weight('bold'),

        TextColumn::make('data.title')
          ->label('عنوان الإشعار')
          ->searchable(),

        TextColumn::make('data.body')
          ->label('المحتوى')
          ->limit(50)
          ->searchable(),

        IconColumn::make('read_at')
          ->label('مقروء')
          ->boolean()
          ->getStateUsing(fn($record) => $record->read_at !== null)
          ->sortable(),

        TextColumn::make('created_at')
          ->label('وقت الإرسال')
          ->dateTime('Y-m-d H:i')
          ->sortable(),
      ])
      ->filters([
        TrashedFilter::make()
          ->label('حالة الإشعار')
          ->native(false),
      ])
      ->recordActions([
        ViewAction::make(),
        // EditAction::make(),
      ])
      ->headerActions([])
      ->bulkActions([
        BulkActionGroup::make([
          BulkAction::make('soft_delete')
            ->label('حذف')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (Collection $records) {
              $records->each(function ($record) {
                $record->delete();
              });
            }),
        ]),
      ]);
  }
}
