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

  public function getTabs(): array
  {
    $admins = User::role(['super_admin'])->get();

    $tabs = [
      'all' => Tab::make('الكل'),
    ];

    foreach ($admins as $admin) {
      $tabs[$admin->id] = Tab::make($admin->name)
        ->modifyQueryUsing(
          fn(Builder $query) => $query
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $admin->id)
        );
    }

    return $tabs;
  }
}
