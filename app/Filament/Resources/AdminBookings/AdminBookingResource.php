<?php

namespace App\Filament\Resources\AdminBookings;

use App\Filament\Resources\AdminBookings\Pages\CreateAdminBooking;
use App\Filament\Resources\AdminBookings\Pages\EditAdminBooking;
use App\Filament\Resources\AdminBookings\Pages\ListAdminBookings;
use App\Filament\Resources\AdminBookings\Pages\ViewAdminBooking;
use App\Filament\Resources\AdminBookings\Schemas\AdminBookingForm;
use App\Filament\Resources\AdminBookings\Schemas\AdminBookingInfolist;
use App\Filament\Resources\AdminBookings\Tables\AdminBookingsTable;
use App\Models\AdminBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AdminBookingResource extends Resource
{
  protected static ?string $model = AdminBooking::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;
  protected static ?string $navigationLabel = 'الحجوزات الإدارية';

  protected static ?string $modelLabel = 'حجز إداري';

  protected static ?string $pluralModelLabel = 'الحجوزات الإدارية';

  protected static ?int $navigationSort = 5;

  protected static UnitEnum|string|null $navigationGroup = 'إدارة العمال والتشغيل';
  protected static ?string $recordTitleAttribute = 'AdminBooking';

  public static function form(Schema $schema): Schema
  {
    return AdminBookingForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return AdminBookingInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return AdminBookingsTable::configure($table);
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
      'index' => ListAdminBookings::route('/'),
      'create' => CreateAdminBooking::route('/create'),
      'view' => ViewAdminBooking::route('/{record}'),
      'edit' => EditAdminBooking::route('/{record}/edit'),
    ];
  }
}
