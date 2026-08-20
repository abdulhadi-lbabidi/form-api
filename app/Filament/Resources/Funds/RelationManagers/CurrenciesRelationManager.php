<?php

namespace App\Filament\Resources\Funds\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CurrenciesRelationManager extends RelationManager
{
  protected static string $relationship = 'currencies';
  protected static ?string $navigationLabel = 'العملات والأرصدة';
  protected static ?string $modelLabel = 'عملة الصندوق';
  protected static ?string $pluralModelLabel = 'عملات الصندوق';

  public function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('balance')
          ->label('الرصيد')
          ->numeric()
          ->step('0.01')
          ->default(0)
          ->required()
          ->extraInputAttributes(['dir' => 'ltr', 'style' => 'text-align: left;']),

        TextInput::make('min_withdrawal_threshold')
          ->label('عتبة الحد الأدنى للسحب')
          ->numeric()
          ->step('0.01')
          ->default(0)
          ->required()
          ->extraInputAttributes(['dir' => 'ltr', 'style' => 'text-align: left;']),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->defaultSort('currencies.created_at', 'desc')
      ->recordTitleAttribute('name')
      ->columns([
        TextColumn::make('name')
          ->label('اسم العملة')
          ->searchable()
          ->weight('bold'),

        TextColumn::make('symbol')
          ->label('الرمز')
          ->badge()
          ->color('success'),

        TextColumn::make('pivot.balance')
          ->label('الرصيد الحالي')
          ->formatStateUsing(fn($state) => number_format((float) $state, 2, '.', ''))
          ->color('primary')
          ->weight('bold')
          ->extraAttributes([
            'style' => 'direction: ltr; text-align: right;',
          ]),

        TextColumn::make('pivot.min_withdrawal_threshold')
          ->label('عتبة السحب')
          ->formatStateUsing(fn($state) => number_format((float) $state, 2, '.', ''))
          ->color('warning')
          ->extraAttributes([
            'style' => 'direction: ltr; text-align: right;',
          ]),
      ])
      ->headerActions([
        AttachAction::make()
          ->label('ربط عملة بالصندوق')
          ->preloadRecordSelect()
          ->form(fn(AttachAction $action): array => [
            $action->getRecordSelect(),

            TextInput::make('balance')
              ->label('الرصيد الابتدائي')
              ->numeric()
              ->step('0.01')
              ->default(0)
              ->required()
              ->extraInputAttributes(['dir' => 'ltr', 'style' => 'text-align: left;']),

            TextInput::make('min_withdrawal_threshold')
              ->label('عتبة الحد الأدنى للسحب')
              ->numeric()
              ->step('0.01')
              ->default(0)
              ->required()
              ->extraInputAttributes(['dir' => 'ltr', 'style' => 'text-align: left;']),
          ]),
      ])
      ->recordActions([
        EditAction::make()
          ->label('تعديل الأرصدة')
          ->fillForm(fn($record): array => [
            'balance' => $record->pivot->balance,
            'min_withdrawal_threshold' => $record->pivot->min_withdrawal_threshold,
          ])
          ->action(function (EditAction $action, $record, array $data): void {
            $record->pivot->update([
              'balance' => $data['balance'],
              'min_withdrawal_threshold' => $data['min_withdrawal_threshold'],
            ]);

            $action->success();
          }),

        DetachAction::make()
          ->label('إلغاء الربط'),
      ]);
  }
}
