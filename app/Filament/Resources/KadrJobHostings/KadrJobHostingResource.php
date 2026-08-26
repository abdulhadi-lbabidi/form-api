<?php

namespace App\Filament\Resources\KadrJobHostings;

use App\Filament\Resources\KadrJobHostings\Pages\CreateKadrJobHosting;
use App\Filament\Resources\KadrJobHostings\Pages\EditKadrJobHosting;
use App\Filament\Resources\KadrJobHostings\Pages\ListKadrJobHostings;
use App\Filament\Resources\KadrJobHostings\Pages\ViewKadrJobHosting;
use App\Filament\Resources\KadrJobHostings\Schemas\KadrJobHostingForm;
use App\Filament\Resources\KadrJobHostings\Schemas\KadrJobHostingInfolist;
use App\Filament\Resources\KadrJobHostings\Tables\KadrJobHostingsTable;
use App\Models\KadrJobHosting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class KadrJobHostingResource extends Resource
{
  protected static ?string $model = KadrJobHosting::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
  protected static ?string $navigationLabel = 'شواغر الكوادر';
  protected static ?string $modelLabel = 'شاغر وظيفي';
  protected static ?string $pluralModelLabel = 'شواغر الكوادر';
  protected static ?int $navigationSort = 3;
  protected static UnitEnum|string|null $navigationGroup = 'إدارة الكوادر';
  protected static ?string $recordTitleAttribute = 'title';

  public static function form(Schema $schema): Schema
  {
    return KadrJobHostingForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return KadrJobHostingInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return KadrJobHostingsTable::configure($table);
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
      'index' => ListKadrJobHostings::route('/'),
      'create' => CreateKadrJobHosting::route('/create'),
      'view' => ViewKadrJobHosting::route('/{record}'),
      'edit' => EditKadrJobHosting::route('/{record}/edit'),
    ];
  }
}
