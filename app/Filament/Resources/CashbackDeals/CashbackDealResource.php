<?php

namespace App\Filament\Resources\CashbackDeals;

use App\Filament\Resources\CashbackDeals\Pages\CreateCashbackDeal;
use App\Filament\Resources\CashbackDeals\Pages\EditCashbackDeal;
use App\Filament\Resources\CashbackDeals\Pages\ListCashbackDeals;
use App\Filament\Resources\CashbackDeals\Pages\ViewCashbackDeal;
use App\Filament\Resources\CashbackDeals\Schemas\CashbackDealForm;
use App\Filament\Resources\CashbackDeals\Schemas\CashbackDealInfolist;
use App\Filament\Resources\CashbackDeals\Tables\CashbackDealsTable;
use App\Models\CashbackDeal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CashbackDealResource extends Resource
{
  protected static ?string $model = CashbackDeal::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

  protected static ?string $navigationLabel = 'عروض الإعلانات';
  protected static ?string $modelLabel = 'عرض إعلان';
  protected static ?string $pluralModelLabel = 'عروض الإعلانات';
  protected static ?int $navigationSort = 3;

  protected static UnitEnum|string|null $navigationGroup = 'الإعلانات';
  protected static ?string $recordTitleAttribute = 'CashbackDeal';

  public static function form(Schema $schema): Schema
  {
    return CashbackDealForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CashbackDealInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CashbackDealsTable::configure($table);
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
      'index' => ListCashbackDeals::route('/'),
      'create' => CreateCashbackDeal::route('/create'),
      'view' => ViewCashbackDeal::route('/{record}'),
      'edit' => EditCashbackDeal::route('/{record}/edit'),
    ];
  }
}
