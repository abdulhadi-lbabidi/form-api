<?php

namespace App\Filament\Resources\Marketings;

use App\Filament\Resources\Marketings\Pages\CreateMarketing;
use App\Filament\Resources\Marketings\Pages\EditMarketing;
use App\Filament\Resources\Marketings\Pages\ListMarketings;
use App\Filament\Resources\Marketings\Pages\ViewMarketing;
use App\Filament\Resources\Marketings\Schemas\MarketingForm;
use App\Filament\Resources\Marketings\Schemas\MarketingInfolist;
use App\Filament\Resources\Marketings\Tables\MarketingsTable;
use BackedEnum;
use App\Models\MarketingSource;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MarketingResource extends Resource
{
  protected static ?string $model = MarketingSource::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationLabel = 'مصادر التسويق';
  protected static ?string $modelLabel = 'مصدر تسويقي';
  protected static ?string $pluralModelLabel = 'مصادر التسويق';
  protected static ?int $navigationSort = 4;

  protected static ?string $recordTitleAttribute = 'MarketingResource';

  public static function form(Schema $schema): Schema
  {
    return MarketingForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return MarketingInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return MarketingsTable::configure($table);
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
      'index' => ListMarketings::route('/'),
      'create' => CreateMarketing::route('/create'),
      'view' => ViewMarketing::route('/{record}'),
      'edit' => EditMarketing::route('/{record}/edit'),
    ];
  }

  public static function getRecordRouteBindingEloquentQuery(): Builder
  {
    return parent::getRecordRouteBindingEloquentQuery()
      ->withoutGlobalScopes([
        SoftDeletingScope::class,
      ]);
  }
}
