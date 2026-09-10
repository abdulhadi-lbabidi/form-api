<?php

namespace App\Filament\Resources\FailedRegistrationAttempts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FailedRegistrationAttemptForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('target_type')
          ->required(),
        TextInput::make('phone')
          ->tel(),
        TextInput::make('ip_address'),
        Textarea::make('user_agent')
          ->columnSpanFull(),
        TextInput::make('payload'),
        TextInput::make('platform'),
        TextInput::make('browser'),
      ]);
  }
}
