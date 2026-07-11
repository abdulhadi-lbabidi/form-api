<?php

namespace App\Filament\Resources\Times;

use App\Filament\Resources\Times\Pages\CreateTime;
use App\Filament\Resources\Times\Pages\EditTime;
use App\Filament\Resources\Times\Pages\ListTimes;
use App\Filament\Resources\Times\Pages\ViewTime;
use App\Filament\Resources\Times\Schemas\TimeForm;
use App\Filament\Resources\Times\Schemas\TimeInfolist;
use App\Filament\Resources\Times\Tables\TimesTable;
use App\Models\Time;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TimeResource extends Resource
{
  protected static ?string $model = Time::class;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
  protected static ?string $navigationLabel = 'أوقات الدوام';
  protected static ?string $modelLabel = 'وقت';
  protected static ?string $pluralModelLabel = 'أوقات الدوام';
  protected static ?int $navigationSort = 5;
  protected static UnitEnum|string|null $navigationGroup = 'إدارة العمال والتشغيل';
  protected static ?string $recordTitleAttribute = 'Time';

  public static function form(Schema $schema): Schema
  {
    return TimeForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return TimeInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return TimesTable::configure($table);
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
      'index' => ListTimes::route('/'),
      'create' => CreateTime::route('/create'),
      'view' => ViewTime::route('/{record}'),
      'edit' => EditTime::route('/{record}/edit'),
    ];
  }
}
