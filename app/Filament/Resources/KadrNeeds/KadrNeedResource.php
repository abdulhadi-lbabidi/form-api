<?php

namespace App\Filament\Resources\KadrNeeds;

use App\Filament\Resources\KadrNeeds\Pages\CreateKadrNeed;
use App\Filament\Resources\KadrNeeds\Pages\EditKadrNeed;
use App\Filament\Resources\KadrNeeds\Pages\ListKadrNeeds;
use App\Filament\Resources\KadrNeeds\Pages\ViewKadrNeed;
use App\Filament\Resources\KadrNeeds\Schemas\KadrNeedForm;
use App\Filament\Resources\KadrNeeds\Schemas\KadrNeedInfolist;
use App\Filament\Resources\KadrNeeds\Tables\KadrNeedsTable;
use App\Models\KadrNeed;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use UnitEnum;

class KadrNeedResource extends Resource
{
  protected static ?string $model = KadrNeed::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
  protected static ?string $navigationLabel = 'احتياجات الكوادر';
  protected static ?string $modelLabel = 'احتياج كادر';
  protected static ?string $pluralModelLabel = 'احتياجات الكوادر';
  protected static ?int $navigationSort = 2;
  protected static UnitEnum|string|null $navigationGroup = 'إدارة الكوادر';

  protected static ?string $recordTitleAttribute = 'KadrNeed';

  public static function form(Schema $schema): Schema
  {
    return KadrNeedForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return KadrNeedInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return KadrNeedsTable::configure($table);
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
      'index' => ListKadrNeeds::route('/'),
      'create' => CreateKadrNeed::route('/create'),
      'view' => ViewKadrNeed::route('/{record}'),
      'edit' => EditKadrNeed::route('/{record}/edit'),
    ];
  }
}
