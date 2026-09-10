<?php

namespace App\Filament\Resources\FailedRegistrationAttempts;

use App\Filament\Resources\FailedRegistrationAttempts\Pages\CreateFailedRegistrationAttempt;
use App\Filament\Resources\FailedRegistrationAttempts\Pages\EditFailedRegistrationAttempt;
use App\Filament\Resources\FailedRegistrationAttempts\Pages\ListFailedRegistrationAttempts;
use App\Filament\Resources\FailedRegistrationAttempts\Pages\ViewFailedRegistrationAttempt;
use App\Filament\Resources\FailedRegistrationAttempts\Schemas\FailedRegistrationAttemptForm;
use App\Filament\Resources\FailedRegistrationAttempts\Schemas\FailedRegistrationAttemptInfolist;
use App\Filament\Resources\FailedRegistrationAttempts\Tables\FailedRegistrationAttemptsTable;
use App\Models\FailedRegistrationAttempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FailedRegistrationAttemptResource extends Resource
{
  protected static ?string $model = FailedRegistrationAttempt::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-exclamation';
  protected static ?string $navigationLabel = 'تتبع محاولات التسجيل بنفس الرقم';
  protected static ?string $modelLabel = 'تتبع محاولة تسجيل';
  protected static ?string $pluralModelLabel = 'محاولات التسجيل ';
  protected static ?int $navigationSort = 6;
  protected static UnitEnum|string|null $navigationGroup = 'إدارة النظام';
  protected static ?string $recordTitleAttribute = 'FailedRegistrationAttempt';

  public static function form(Schema $schema): Schema
  {
    return FailedRegistrationAttemptForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return FailedRegistrationAttemptInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return FailedRegistrationAttemptsTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListFailedRegistrationAttempts::route('/'),
      'create' => CreateFailedRegistrationAttempt::route('/create'),
      'view' => ViewFailedRegistrationAttempt::route('/{record}'),
      'edit' => EditFailedRegistrationAttempt::route('/{record}/edit'),
    ];
  }
}
