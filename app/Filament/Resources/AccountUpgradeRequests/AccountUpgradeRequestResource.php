<?php

namespace App\Filament\Resources\AccountUpgradeRequests;

use App\Filament\Resources\AccountUpgradeRequests\Pages\CreateAccountUpgradeRequest;
use App\Filament\Resources\AccountUpgradeRequests\Pages\EditAccountUpgradeRequest;
use App\Filament\Resources\AccountUpgradeRequests\Pages\ListAccountUpgradeRequests;
use App\Filament\Resources\AccountUpgradeRequests\Pages\ViewAccountUpgradeRequest;
use App\Filament\Resources\AccountUpgradeRequests\Schemas\AccountUpgradeRequestForm;
use App\Filament\Resources\AccountUpgradeRequests\Schemas\AccountUpgradeRequestInfolist;
use App\Filament\Resources\AccountUpgradeRequests\Tables\AccountUpgradeRequestsTable;
use App\Models\AccountUpgradeRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AccountUpgradeRequestResource extends Resource
{
  protected static ?string $model = AccountUpgradeRequest::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

  protected static UnitEnum|string|null $navigationGroup = 'طلبات الترقية';

  protected static ?string $navigationLabel = 'طلبات الترقية المعلقة';
  protected static ?string $modelLabel = 'طلب الترقية';
  protected static ?string $pluralModelLabel = 'طلبات الترقية';
  protected static ?string $recordTitleAttribute = 'AccountUpgradeRequest';

  public static function form(Schema $schema): Schema
  {
    return AccountUpgradeRequestForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return AccountUpgradeRequestInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return AccountUpgradeRequestsTable::configure($table);
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
      'index' => ListAccountUpgradeRequests::route('/'),
      'create' => CreateAccountUpgradeRequest::route('/create'),
      'view' => ViewAccountUpgradeRequest::route('/{record}'),
      'edit' => EditAccountUpgradeRequest::route('/{record}/edit'),
    ];
  }
}
