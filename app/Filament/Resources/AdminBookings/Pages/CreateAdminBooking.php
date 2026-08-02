<?php

namespace App\Filament\Resources\AdminBookings\Pages;

use App\Filament\Resources\AdminBookings\AdminBookingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateAdminBooking extends CreateRecord
{
  protected static string $resource = AdminBookingResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }
}
