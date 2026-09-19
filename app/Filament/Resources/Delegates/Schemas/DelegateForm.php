<?php

namespace App\Filament\Resources\Delegates\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class DelegateForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('user_id')
          ->relationship('user', 'name')
          ->label('المستخدم المرتبط')
          ->required()
          ->searchable()
          ->preload()
          ->createOptionForm([
            TextInput::make('name')
              ->label('الاسم كاملاً')
              ->required()
              ->maxLength(255),

            TextInput::make('email')
              ->label('البريد الإلكتروني')
              ->email()
              ->required()
              ->unique('users', 'email')
              ->maxLength(255),

            TextInput::make('password')
              ->label('كلمة المرور')
              ->password()
              ->required()
              ->dehydrateStateUsing(fn($state) => Hash::make($state))
              ->maxLength(255),

            TextInput::make('phone_number')
              ->label('رقم الهاتف')
              ->tel()
              ->unique('users', 'phone_number')
              ->maxLength(255),
          ])
          ->createOptionUsing(function (array $data): int {
            $user = User::create([
              'name' => $data['name'],
              'email' => $data['email'],
              'password' => $data['password'],
              'phone_number' => $data['phone_number'] ?? null,
            ]);

            return $user->id;
          })
          ->columnSpanFull(),

        TextInput::make('address')
          ->label('عنوان السكن')
          ->required()
          ->maxLength(255),

        TextInput::make('fixed_salary')
          ->label('الراتب الثابت')
          ->numeric()
          ->prefix('$')
          ->default(0)
          ->required(),

        TextInput::make('commission_rate')
          ->label('  قيمة العمولة')
          ->numeric()
          ->default(0)
          ->required(),

        Textarea::make('commission_description')
          ->label('وصف العمولة')
          ->columnSpanFull()
          ->maxLength(500),
      ]);
  }
}
