<?php

namespace App\Filament\Resources\CompanyFunds;

use App\Filament\Resources\CompanyFunds\Pages\CreateCompanyFund;
use App\Filament\Resources\CompanyFunds\Pages\EditCompanyFund;
use App\Filament\Resources\CompanyFunds\Pages\ListCompanyFunds;
use App\Filament\Resources\CompanyFunds\Pages\ViewCompanyFund;
use App\Filament\Resources\CompanyFunds\Schemas\CompanyFundForm;
use App\Filament\Resources\CompanyFunds\Schemas\CompanyFundInfolist;
use App\Filament\Resources\CompanyFunds\Tables\CompanyFundsTable;
use App\Filament\Resources\Funds\RelationManagers\CurrenciesRelationManager;
use App\Models\CompanyFund;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompanyFundResource extends Resource
{
  protected static ?string $model = CompanyFund::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

  protected static ?string $navigationLabel = 'صناديق الشركة';
  protected static ?string $modelLabel = 'صندوق الشركة';
  protected static ?string $pluralModelLabel = 'صناديق الشركة';
  protected static ?int $navigationSort = 1;
  protected static UnitEnum|string|null $navigationGroup = 'المالية';
  protected static ?string $recordTitleAttribute = 'name';

  public static function form(Schema $schema): Schema
  {
    return CompanyFundForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CompanyFundInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CompanyFundsTable::configure($table);
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
      'index' => ListCompanyFunds::route('/'),
      'create' => CreateCompanyFund::route('/create'),
      'view' => ViewCompanyFund::route('/{record}'),
      'edit' => EditCompanyFund::route('/{record}/edit'),
    ];
  }
}
