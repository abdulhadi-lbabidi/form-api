<?php

namespace App\Filament\Resources\Notifications\Pages;

use App\Filament\Resources\Notifications\NotificationResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListNotifications extends ListRecords
{
  protected static string $resource = NotificationResource::class;

  // protected function getHeaderActions(): array
  // {
  //   return [
  //     CreateAction::make(),
  //   ];
  // }


}
