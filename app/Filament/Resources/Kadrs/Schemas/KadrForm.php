<?php

namespace App\Filament\Resources\Kadrs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KadrForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->label('الاسم')
          ->required()
          ->maxLength(255),

        TextInput::make('number_of_person')
          ->label('عدد الاأشخاص')
          ->numeric(),

        TextInput::make('phone')
          ->label('رقم الهاتف')
          ->required()
          ->unique(table: 'kadrs', column: 'phone', ignoreRecord: true)
          ->maxLength(255),

        TextInput::make('email')
          ->label('البريد الإلكتروني')
          ->email()
          ->nullable()
          ->maxLength(255),

        TextInput::make('password')
          ->label('كلمة المرور')
          ->password()
          ->revealable()
          ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
          ->dehydrated(fn($state) => filled($state))
          ->required(fn(string $context): bool => $context === 'create')
          ->placeholder('اتركه فارغاً للإبقاء على كلمة المرور الحالية')
          ->maxLength(255),

        TextInput::make('city')
          ->label('المدينة')
          ->maxLength(255),

        TextInput::make('shop_address')
          ->label('عنوان المحل / العمل')
          ->maxLength(255)
          ->columnSpanFull(),
      ]);
  }
}
