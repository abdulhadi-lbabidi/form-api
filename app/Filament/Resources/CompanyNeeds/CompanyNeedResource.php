<?php

namespace App\Filament\Resources\CompanyNeeds;

use App\Filament\Resources\CompanyNeeds\Pages\CreateCompanyNeed;
use App\Filament\Resources\CompanyNeeds\Pages\EditCompanyNeed;
use App\Filament\Resources\CompanyNeeds\Pages\ListCompanyNeeds;
use App\Filament\Resources\CompanyNeeds\Pages\ViewCompanyNeed;
use App\Filament\Resources\CompanyNeeds\Schemas\CompanyNeedForm;
use App\Filament\Resources\CompanyNeeds\Schemas\CompanyNeedInfolist;
use App\Filament\Resources\CompanyNeeds\Tables\CompanyNeedsTable;
use App\Models\CompanyNeed;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompanyNeedResource extends Resource
{
  protected static ?string $model = CompanyNeed::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
  protected static ?string $navigationLabel = 'احتياجات الشركات';
  protected static ?string $modelLabel = 'احتياج';
  protected static ?string $pluralModelLabel = 'احتياجات الشركات';
  protected static ?int $navigationSort = 3;
  protected static UnitEnum|string|null $navigationGroup = 'إدارة الشركات';

  protected static ?string $recordTitleAttribute = 'CompanyNeed';

  public static function form(Schema $schema): Schema
  {
    return CompanyNeedForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CompanyNeedInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CompanyNeedsTable::configure($table);
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
      'index' => ListCompanyNeeds::route('/'),
      'create' => CreateCompanyNeed::route('/create'),
      'view' => ViewCompanyNeed::route('/{record}'),
      'edit' => EditCompanyNeed::route('/{record}/edit'),
    ];
  }
}
