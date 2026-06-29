<?php

namespace App\Filament\Resources\ReferralCodes;

use App\Filament\Resources\ReferralCodes\Pages\CreateReferralCode;
use App\Filament\Resources\ReferralCodes\Pages\EditReferralCode;
use App\Filament\Resources\ReferralCodes\Pages\ListReferralCodes;
use App\Filament\Resources\ReferralCodes\Pages\ViewReferralCode;
use App\Filament\Resources\ReferralCodes\Schemas\ReferralCodeForm;
use App\Filament\Resources\ReferralCodes\Schemas\ReferralCodeInfolist;
use App\Filament\Resources\ReferralCodes\Tables\ReferralCodesTable;
use App\Models\ReferralCode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReferralCodeResource extends Resource
{
  protected static ?string $model = ReferralCode::class;

  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

  protected static ?string $navigationLabel = 'أكواد الإحالة';
  protected static ?string $modelLabel = 'كود إحالة';
  protected static ?string $pluralModelLabel = 'أكواد الإحالة';
  protected static ?int $navigationSort = 3;
  protected static ?string $recordTitleAttribute = 'ReferralCode';

  public static function form(Schema $schema): Schema
  {
    return ReferralCodeForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return ReferralCodeInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return ReferralCodesTable::configure($table);
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
      'index' => ListReferralCodes::route('/'),
      'create' => CreateReferralCode::route('/create'),
      'view' => ViewReferralCode::route('/{record}'),
      'edit' => EditReferralCode::route('/{record}/edit'),
    ];
  }
}
