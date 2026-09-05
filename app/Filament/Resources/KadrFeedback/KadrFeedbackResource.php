<?php

namespace App\Filament\Resources\KadrFeedback;

use App\Filament\Resources\KadrFeedback\Pages\CreateKadrFeedback;
use App\Filament\Resources\KadrFeedback\Pages\EditKadrFeedback;
use App\Filament\Resources\KadrFeedback\Pages\ListKadrFeedback;
use App\Filament\Resources\KadrFeedback\Pages\ViewKadrFeedback;
use App\Filament\Resources\KadrFeedback\Schemas\KadrFeedbackForm;
use App\Filament\Resources\KadrFeedback\Schemas\KadrFeedbackInfolist;
use App\Filament\Resources\KadrFeedback\Tables\KadrFeedbackTable;
use App\Models\KadrFeedback;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KadrFeedbackResource extends Resource
{
  protected static ?string $model = KadrFeedback::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;
  protected static ?string $navigationLabel = 'تقييمات الكوادر';
  protected static ?string $modelLabel = 'تقييم كادر';
  protected static ?int $navigationSort = 3;

  protected static ?string $pluralModelLabel = 'تقييمات الكوادر';
  protected static UnitEnum|string|null $navigationGroup = 'المراجعات';

  protected static ?string $recordTitleAttribute = 'KadrFeedback';

  public static function form(Schema $schema): Schema
  {
    return KadrFeedbackForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return KadrFeedbackInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return KadrFeedbackTable::configure($table);
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
      'index' => ListKadrFeedback::route('/'),
      'create' => CreateKadrFeedback::route('/create'),
      'view' => ViewKadrFeedback::route('/{record}'),
      'edit' => EditKadrFeedback::route('/{record}/edit'),
    ];
  }
}
