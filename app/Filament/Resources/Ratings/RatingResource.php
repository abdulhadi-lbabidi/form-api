<?php

namespace App\Filament\Resources\Ratings;

use App\Filament\Resources\Ratings\Pages\CreateRating;
use App\Filament\Resources\Ratings\Pages\EditRating;
use App\Filament\Resources\Ratings\Pages\ListRatings;
use App\Filament\Resources\Ratings\Pages\ViewRating;
use App\Filament\Resources\Ratings\Schemas\RatingForm;
use App\Filament\Resources\Ratings\Schemas\RatingInfolist;
use App\Filament\Resources\Ratings\Tables\RatingsTable;
use App\Models\Rating;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class RatingResource extends Resource
{
  protected static ?string $model = Rating::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-star';

  protected static ?string $navigationLabel = 'التقييمات';
  protected static ?string $modelLabel = 'تقييم';
  protected static ?string $pluralModelLabel = 'التقييمات';

  protected static ?int $navigationSort = 3;
  protected static UnitEnum|string|null $navigationGroup = 'إدارة العمال والتشغيل';
  protected static ?string $recordTitleAttribute = 'Rating';

  public static function form(Schema $schema): Schema
  {
    return RatingForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return RatingInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return RatingsTable::configure($table);
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
      'index' => ListRatings::route('/'),
      'create' => CreateRating::route('/create'),
      'view' => ViewRating::route('/{record}'),
      'edit' => EditRating::route('/{record}/edit'),
    ];
  }
}
