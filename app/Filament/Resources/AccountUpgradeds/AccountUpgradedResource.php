<?php

namespace App\Filament\Resources\AccountUpgradeds;

use App\Filament\Resources\AccountUpgradeds\Pages\CreateAccountUpgraded;
use App\Filament\Resources\AccountUpgradeds\Pages\EditAccountUpgraded;
use App\Filament\Resources\AccountUpgradeds\Pages\ListAccountUpgradeds;
use App\Filament\Resources\AccountUpgradeds\Pages\ViewAccountUpgraded;
use App\Filament\Resources\AccountUpgradeds\Schemas\AccountUpgradedForm;
use App\Filament\Resources\AccountUpgradeds\Schemas\AccountUpgradedInfolist;
use App\Filament\Resources\AccountUpgradeds\Tables\AccountUpgradedsTable;
use App\Models\AccountUpgraded;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AccountUpgradedResource extends Resource
{
  protected static ?string $model = AccountUpgraded::class;
  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
  protected static ?string $navigationLabel = 'طلبات اللترقية';
  protected static ?string $modelLabel = 'طلب الترقية';
  protected static ?string $pluralModelLabel = 'طلبات الترقية';

  protected static UnitEnum|string|null $navigationGroup = 'طلبات الترقية';

  protected static ?string $recordTitleAttribute = 'AccountUpgraded';

  public static function form(Schema $schema): Schema
  {
    return AccountUpgradedForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return AccountUpgradedInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return AccountUpgradedsTable::configure($table);
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
      'index' => ListAccountUpgradeds::route('/'),
      'create' => CreateAccountUpgraded::route('/create'),
      'view' => ViewAccountUpgraded::route('/{record}'),
      'edit' => EditAccountUpgraded::route('/{record}/edit'),
    ];
  }
}
