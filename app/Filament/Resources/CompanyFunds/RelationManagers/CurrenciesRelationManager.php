<?php

namespace App\Filament\Resources\CompanyFundResource\RelationManagers;

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

  public function form(Schema $schema): Schema
  {
    return $schema->components([
      TextInput::make('balance')->numeric()->required()->label('الرصيد'),
      TextInput::make('min_withdrawal_threshold')->numeric()->required()->label('عتبة السحب'),
    ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->label('العملة'),
        TextColumn::make('pivot.balance')->label('الرصيد'),
        TextColumn::make('pivot.min_withdrawal_threshold')->label('عتبة السحب'),
      ])
      ->headerActions([
        AttachAction::make()
          ->form(fn(AttachAction $action): array => [
            $action->getRecordSelect(),
            TextInput::make('balance')->numeric()->default(0)->required(),
            TextInput::make('min_withdrawal_threshold')->numeric()->default(0)->required(),
          ]),
      ])
      ->recordActions([
        EditAction::make()
          ->fillForm(fn($record): array => [
            'balance' => $record->pivot->balance,
            'min_withdrawal_threshold' => $record->pivot->min_withdrawal_threshold,
          ])
          ->action(function ($record, array $data): void {
            $record->pivot->update([
              'balance' => $data['balance'],
              'min_withdrawal_threshold' => $data['min_withdrawal_threshold'],
            ]);
          }),
        DetachAction::make(),
      ]);
  }
}
