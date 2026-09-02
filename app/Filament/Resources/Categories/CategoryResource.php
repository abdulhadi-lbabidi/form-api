<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Pages\ViewCategory;
use App\Filament\Resources\Categories\RelationManagers\CompaniesRelationManager;
use App\Filament\Resources\Categories\RelationManagers\CompanyJobHostingsRelationManager;
use App\Filament\Resources\Categories\RelationManagers\KadrJobHostingsRelationManager;
use App\Filament\Resources\Categories\RelationManagers\KadrsRelationManager;
use App\Filament\Resources\Categories\RelationManagers\WorkersRelationManager;
use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Categories\Schemas\CategoryInfolist;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CategoryResource extends Resource
{
  protected static ?string $model = Category::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

  protected static ?string $navigationLabel = 'التصنيفات';
  protected static ?string $modelLabel = 'تصنيف';
  protected static ?string $pluralModelLabel = 'التصنيفات';

  protected static UnitEnum|string|null $navigationGroup = 'إدارة العمال والتشغيل';
  protected static ?int $navigationSort = 1;

  protected static ?string $recordTitleAttribute = 'Category';

  public static function form(Schema $schema): Schema
  {
    return CategoryForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CategoryInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CategoriesTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      WorkersRelationManager::class,
      KadrsRelationManager::class,
      CompaniesRelationManager::class,
      CompanyJobHostingsRelationManager::class,
      KadrJobHostingsRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListCategories::route('/'),
      'create' => CreateCategory::route('/create'),
      'view' => ViewCategory::route('/{record}'),
      'edit' => EditCategory::route('/{record}/edit'),
    ];
  }
}
