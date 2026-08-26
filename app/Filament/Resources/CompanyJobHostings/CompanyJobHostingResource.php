<?php

namespace App\Filament\Resources\CompanyJobHostings;

use App\Filament\Resources\CompanyJobHostings\Pages\CreateCompanyJobHosting;
use App\Filament\Resources\CompanyJobHostings\Pages\EditCompanyJobHosting;
use App\Filament\Resources\CompanyJobHostings\Pages\ListCompanyJobHostings;
use App\Filament\Resources\CompanyJobHostings\Pages\ViewCompanyJobHosting;
use App\Filament\Resources\CompanyJobHostings\Schemas\CompanyJobHostingForm;
use App\Filament\Resources\CompanyJobHostings\Schemas\CompanyJobHostingInfolist;
use App\Filament\Resources\CompanyJobHostings\Tables\CompanyJobHostingsTable;
use App\Models\CompanyJobHosting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompanyJobHostingResource extends Resource
{
  protected static ?string $model = CompanyJobHosting::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
  protected static ?string $navigationLabel = 'شواغر الشركات';
  protected static ?string $modelLabel = 'شاغر شركة';
  protected static ?string $pluralModelLabel = 'شواغر الشركات';
  protected static ?int $navigationSort = 4;
  protected static UnitEnum|string|null $navigationGroup = 'إدارة الشركات';
  protected static ?string $recordTitleAttribute = 'title';

  public static function form(Schema $schema): Schema
  {
    return CompanyJobHostingForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CompanyJobHostingInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CompanyJobHostingsTable::configure($table);
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
      'index' => ListCompanyJobHostings::route('/'),
      'create' => CreateCompanyJobHosting::route('/create'),
      'view' => ViewCompanyJobHosting::route('/{record}'),
      'edit' => EditCompanyJobHosting::route('/{record}/edit'),
    ];
  }
}
