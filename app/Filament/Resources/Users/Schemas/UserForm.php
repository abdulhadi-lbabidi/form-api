<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->required(),
        TextInput::make('email')
          ->label('Email address')
          ->email()
          ->required(),
        TextInput::make('password')
          ->label('كلمة المرور')
          ->password()
          ->required(fn(string $context): bool => $context === 'create') // مطلوبة فقط عند الإنشاء
          ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null) // تشفيرها إذا تم إدخالها
          ->dehydrated(fn($state) => filled($state)) // عدم تحديثها إذا كانت فارغة عند التعديل
          ->hiddenOn('view'),
        Select::make('roles')
          ->relationship('roles', 'name')
          ->multiple()
          ->preload()
          ->searchable()
          ->label('الدور / الصلاحية'),
      ]);
  }
}
