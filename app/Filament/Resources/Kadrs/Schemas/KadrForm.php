<?php

namespace App\Filament\Resources\Kadrs\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class KadrForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Tabs::make('بيانات الكادر')
          ->columnSpanFull()
          ->tabs([

            Tabs\Tab::make('المعلومات الأساسية')
              ->columns(2)
              ->schema([
                TextInput::make('name')
                  ->label('الاسم')
                  ->required()
                  ->maxLength(255),

                TextInput::make('number_of_person')
                  ->label('عدد الأشخاص')
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
                  ->maxLength(255)
                  ->columnSpanFull(),
              ]),

            Tabs\Tab::make('الموقع والعنوان')
              ->columns(2)
              ->schema([
                TextInput::make('city')
                  ->label('المدينة')
                  ->maxLength(255)
                  ->columnSpanFull(),

                TextInput::make('shop_address')
                  ->label('عنوان المحل / العمل')
                  ->maxLength(255)
                  ->columnSpanFull(),
              ]),

            Tabs\Tab::make('مصادر التسويق')
              ->schema([
                CheckboxList::make('marketingSources')
                  ->relationship('marketingSources', 'name')
                  ->getOptionLabelFromRecordUsing(fn($record) => $record->translated_name)
                  ->label('مصادر التعرف علينا')
                  ->columns(3),
              ]),

          ]),
      ]);
  }
}
