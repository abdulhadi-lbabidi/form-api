<?php

namespace App\Filament\Resources\AdminBookings\Pages;

use App\Filament\Resources\AdminBookings\AdminBookingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;


class ViewAdminBooking extends ViewRecord
{
  protected static string $resource = AdminBookingResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      EditAction::make(),
    ];
  }
}
