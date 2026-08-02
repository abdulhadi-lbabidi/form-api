<?php

namespace App\Filament\Resources\AdminBookings\Pages;

use App\Filament\Resources\AdminBookings\AdminBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdminBookings extends ListRecords
{
    protected static string $resource = AdminBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
