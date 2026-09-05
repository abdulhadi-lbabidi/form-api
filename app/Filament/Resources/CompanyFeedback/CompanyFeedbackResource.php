<?php

namespace App\Filament\Resources\CompanyFeedback;

use App\Filament\Resources\CompanyFeedback\Pages\CreateCompanyFeedback;
use App\Filament\Resources\CompanyFeedback\Pages\EditCompanyFeedback;
use App\Filament\Resources\CompanyFeedback\Pages\ListCompanyFeedback;
use App\Filament\Resources\CompanyFeedback\Pages\ViewCompanyFeedback;
use App\Filament\Resources\CompanyFeedback\Schemas\CompanyFeedbackForm;
use App\Filament\Resources\CompanyFeedback\Schemas\CompanyFeedbackInfolist;
use App\Filament\Resources\CompanyFeedback\Tables\CompanyFeedbackTable;
use App\Models\CompanyFeedback;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompanyFeedbackResource extends Resource
{
  protected static ?string $model = CompanyFeedback::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;
  protected static ?string $navigationLabel = 'تقييمات الشركات';
  protected static ?string $modelLabel = 'تقييم شركة';
  protected static ?int $navigationSort = 1;

  protected static ?string $pluralModelLabel = 'تقييمات الشركات';
  protected static UnitEnum|string|null $navigationGroup = 'المراجعات';

  protected static ?string $recordTitleAttribute = 'CompanyFeedback';

  public static function form(Schema $schema): Schema
  {
    return CompanyFeedbackForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CompanyFeedbackInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CompanyFeedbackTable::configure($table);
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
      'index' => ListCompanyFeedback::route('/'),
      'create' => CreateCompanyFeedback::route('/create'),
      'view' => ViewCompanyFeedback::route('/{record}'),
      'edit' => EditCompanyFeedback::route('/{record}/edit'),
    ];
  }
}
