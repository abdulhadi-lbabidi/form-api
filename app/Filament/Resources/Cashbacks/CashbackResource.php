<?php

namespace App\Filament\Resources\Cashbacks;

use App\Filament\Resources\Cashbacks\Pages\CreateCashback;
use App\Filament\Resources\Cashbacks\Pages\EditCashback;
use App\Filament\Resources\Cashbacks\Pages\ListCashbacks;
use App\Filament\Resources\Cashbacks\Pages\ViewCashback;
use App\Filament\Resources\Cashbacks\Schemas\CashbackForm;
use App\Filament\Resources\Cashbacks\Schemas\CashbackInfolist;
use App\Filament\Resources\Cashbacks\Tables\CashbacksTable;
use App\Models\Cashback;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CashbackResource extends Resource
{
  protected static ?string $model = Cashback::class;
  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

  protected static ?string $navigationLabel = 'شركات الاعلان';
  protected static ?string $modelLabel =  'شركة الاعلان';
  protected static ?int $navigationSort = 1;

  protected static ?string $pluralModelLabel = 'الإعلانات';
  protected static UnitEnum|string|null $navigationGroup = 'الإعلانات';
  protected static ?string $recordTitleAttribute = 'company_name';

  public static function form(Schema $schema): Schema
  {
    return CashbackForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CashbackInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CashbacksTable::configure($table);
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
      'index' => ListCashbacks::route('/'),
      'create' => CreateCashback::route('/create'),
      'view' => ViewCashback::route('/{record}'),
      'edit' => EditCashback::route('/{record}/edit'),
    ];
  }
}