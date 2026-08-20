<?php

namespace App\Filament\Resources\Funds;

use App\Filament\Resources\Funds\Pages\CreateFund;
use App\Filament\Resources\Funds\Pages\EditFund;
use App\Filament\Resources\Funds\Pages\ListFunds;
use App\Filament\Resources\Funds\Pages\ViewFund;
use App\Filament\Resources\Funds\RelationManagers\CurrenciesRelationManager;
use App\Filament\Resources\Funds\Schemas\FundForm;
use App\Filament\Resources\Funds\Schemas\FundInfolist;
use App\Filament\Resources\Funds\Tables\FundsTable;
use App\Models\Fund;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FundResource extends Resource
{
  protected static ?string $model = Fund::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wallet';
  protected static ?string $navigationLabel = 'صناديق المستخدمين';
  protected static ?string $modelLabel = 'صندوق';
  protected static ?string $pluralModelLabel = 'الصناديق';
  protected static ?int $navigationSort = 2;
  protected static UnitEnum|string|null $navigationGroup = 'المالية';
  protected static ?string $recordTitleAttribute = 'name';


  public static function form(Schema $schema): Schema
  {
    return FundForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return FundInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return FundsTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      CurrenciesRelationManager::class
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListFunds::route('/'),
      'create' => CreateFund::route('/create'),
      'view' => ViewFund::route('/{record}'),
      'edit' => EditFund::route('/{record}/edit'),
    ];
  }
}
