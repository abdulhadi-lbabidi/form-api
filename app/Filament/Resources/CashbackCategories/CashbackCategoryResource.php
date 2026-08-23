<?php

namespace App\Filament\Resources\CashbackCategories;

use App\Filament\Resources\CashbackCategories\Pages\CreateCashbackCategory;
use App\Filament\Resources\CashbackCategories\Pages\EditCashbackCategory;
use App\Filament\Resources\CashbackCategories\Pages\ListCashbackCategories;
use App\Filament\Resources\CashbackCategories\Pages\ViewCashbackCategory;
use App\Filament\Resources\CashbackCategories\Schemas\CashbackCategoryForm;
use App\Filament\Resources\CashbackCategories\Schemas\CashbackCategoryInfolist;
use App\Filament\Resources\CashbackCategories\Tables\CashbackCategoriesTable;
use App\Models\CashbackCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CashbackCategoryResource extends Resource
{
  protected static ?string $model = CashbackCategory::class;
  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
  protected static ?string $navigationLabel = 'تصنيفات الإعلانات';
  protected static ?string $modelLabel = 'تصنيف إعلان';
  protected static ?int $navigationSort = 2;

  protected static ?string $pluralModelLabel = 'تصنيفات الإعلانات';

  protected static UnitEnum|string|null $navigationGroup = 'الإعلانات';

  protected static ?string $recordTitleAttribute = 'name';

  public static function form(Schema $schema): Schema
  {
    return CashbackCategoryForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CashbackCategoryInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CashbackCategoriesTable::configure($table);
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
      'index' => ListCashbackCategories::route('/'),
      'create' => CreateCashbackCategory::route('/create'),
      'view' => ViewCashbackCategory::route('/{record}'),
      'edit' => EditCashbackCategory::route('/{record}/edit'),
    ];
  }
}
