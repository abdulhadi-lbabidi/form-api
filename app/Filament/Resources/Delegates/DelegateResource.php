<?php

namespace App\Filament\Resources\Delegates;

use App\Filament\Resources\Delegates\Pages\CreateDelegate;
use App\Filament\Resources\Delegates\Pages\EditDelegate;
use App\Filament\Resources\Delegates\Pages\ListDelegates;
use App\Filament\Resources\Delegates\Pages\ViewDelegate;
use App\Filament\Resources\Delegates\Schemas\DelegateForm;
use App\Filament\Resources\Delegates\Schemas\DelegateInfolist;
use App\Filament\Resources\Delegates\Tables\DelegatesTable;
use App\Models\Delegate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DelegateResource extends Resource
{
  protected static ?string $model = Delegate::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
  protected static ?string $navigationLabel = 'المندوبين';
  protected static ?string $pluralModelLabel = 'المندوبين';
  protected static ?string $modelLabel = 'مندوب';
  protected static UnitEnum|string|null $navigationGroup = 'إدارة المبيعات';
  protected static ?string $recordTitleAttribute = 'address';

  public static function form(Schema $schema): Schema
  {
    return DelegateForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return DelegateInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return DelegatesTable::configure($table);
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
      'index' => ListDelegates::route('/'),
      'create' => CreateDelegate::route('/create'),
      'view' => ViewDelegate::route('/{record}'),
      'edit' => EditDelegate::route('/{record}/edit'),
    ];
  }
}
