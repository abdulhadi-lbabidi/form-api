<?php

namespace App\Filament\Resources\CashbackCounters;

use App\Filament\Resources\CashbackCounters\Pages\CreateCashbackCounter;
use App\Filament\Resources\CashbackCounters\Pages\EditCashbackCounter;
use App\Filament\Resources\CashbackCounters\Pages\ListCashbackCounters;
use App\Filament\Resources\CashbackCounters\Pages\ViewCashbackCounter;
use App\Filament\Resources\CashbackCounters\Schemas\CashbackCounterForm;
use App\Filament\Resources\CashbackCounters\Schemas\CashbackCounterInfolist;
use App\Filament\Resources\CashbackCounters\Tables\CashbackCountersTable;
use App\Models\CashbackCounter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CashbackCounterResource extends Resource
{
  protected static ?string $model = CashbackCounter::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
  protected static UnitEnum|string|null $navigationGroup = 'الإعلانات';
  public static ?string $navigationLabel = 'عدادات النقرات';
  public static ?string $pluralModelLabel = 'عدادات النقرات';
  public static ?string $modelLabel = 'عداد';
  protected static ?int $navigationSort = 4;
  protected static ?string $recordTitleAttribute = 'CashbackCounter';

  public static function form(Schema $schema): Schema
  {
    return CashbackCounterForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CashbackCounterInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CashbackCountersTable::configure($table);
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
      'index' => ListCashbackCounters::route('/'),
      'create' => CreateCashbackCounter::route('/create'),
      'view' => ViewCashbackCounter::route('/{record}'),
      'edit' => EditCashbackCounter::route('/{record}/edit'),
    ];
  }
}
