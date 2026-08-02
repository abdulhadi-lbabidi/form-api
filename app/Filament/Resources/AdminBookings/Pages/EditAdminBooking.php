<?php

namespace App\Filament\Resources\AdminBookings\Pages;

use App\Filament\Resources\AdminBookings\AdminBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;


class EditAdminBooking extends EditRecord
{
  protected static string $resource = AdminBookingResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }
}