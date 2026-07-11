<?php

namespace App\Filament\Resources\CompanyBranches;

use App\Filament\Resources\CompanyBranches\Pages\CreateCompanyBranch;
use App\Filament\Resources\CompanyBranches\Pages\EditCompanyBranch;
use App\Filament\Resources\CompanyBranches\Pages\ListCompanyBranches;
use App\Filament\Resources\CompanyBranches\Pages\ViewCompanyBranch;
use App\Filament\Resources\CompanyBranches\Schemas\CompanyBranchForm;
use App\Filament\Resources\CompanyBranches\Schemas\CompanyBranchInfolist;
use App\Filament\Resources\CompanyBranches\Tables\CompanyBranchesTable;
use App\Models\CompanyBranch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompanyBranchResource extends Resource
{
  protected static ?string $model = CompanyBranch::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-group';
  protected static ?string $navigationLabel = 'فروع الشركات';
  protected static ?string $modelLabel = 'فرع';
  protected static ?string $pluralModelLabel = 'فروع الشركات';
  protected static UnitEnum|string|null $navigationGroup = 'إدارة الشركات';
  protected static ?int $navigationSort = 2;

  protected static ?string $recordTitleAttribute = 'CompanyBranch';

  public static function form(Schema $schema): Schema
  {
    return CompanyBranchForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CompanyBranchInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CompanyBranchesTable::configure($table);
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
      'index' => ListCompanyBranches::route('/'),
      'create' => CreateCompanyBranch::route('/create'),
      'view' => ViewCompanyBranch::route('/{record}'),
      'edit' => EditCompanyBranch::route('/{record}/edit'),
    ];
  }
}
