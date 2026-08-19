<?php

namespace App\Filament\Resources\Kadrs;

use App\Filament\Resources\Kadrs\Pages\CreateKadr;
use App\Filament\Resources\Kadrs\Pages\EditKadr;
use App\Filament\Resources\Kadrs\Pages\ListKadrs;
use App\Filament\Resources\Kadrs\Pages\ViewKadr;
use App\Filament\Resources\Kadrs\Schemas\KadrForm;
use App\Filament\Resources\Kadrs\Schemas\KadrInfolist;
use App\Filament\Resources\Kadrs\Tables\KadrsTable;
use App\Models\Kadr;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KadrResource extends Resource
{
  protected static ?string $model = Kadr::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';
  protected static ?string $navigationLabel = 'الكوادر';
  protected static ?string $modelLabel = 'كادر';
  protected static ?string $pluralModelLabel = 'الكوادر';
  protected static ?int $navigationSort = 1;

  protected static UnitEnum|string|null $navigationGroup = 'إدارة الكوادر';

  protected static ?string $recordTitleAttribute = 'Kadr';

  public static function form(Schema $schema): Schema
  {
    return KadrForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return KadrInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return KadrsTable::configure($table);
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
      'index' => ListKadrs::route('/'),
      'create' => CreateKadr::route('/create'),
      'view' => ViewKadr::route('/{record}'),
      'edit' => EditKadr::route('/{record}/edit'),
    ];
  }
}
