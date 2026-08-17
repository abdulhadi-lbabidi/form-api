<?php

namespace App\Filament\Resources\Workers\Pages;

use App\Filament\Resources\Workers\WorkerResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateWorker extends CreateRecord
{
  protected static string $resource = WorkerResource::class;

  // protected function getHeaderActions(): array
  // {
  //   return [
  //     Actions\Action::make('back')
  //       ->label('رجوع')
  //       ->color('gray')
  //       ->url($this->getResource()::getUrl('index')),
  //   ];
  // }

  // protected function getRedirectUrl(): string
  // {
  //   return $this->getResource()::getUrl('index');
  // }
  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(function () {
          $referer = request()->header('referer');
          return $referer && str_contains($referer, 'page=') ? $referer : $this->getResource()::getUrl('index');
        }),
    ];
  }

  protected function getRedirectUrl(): string
  {
    $referer = request()->header('referer');

    if ($referer && str_contains($referer, 'page=')) {
      return $referer;
    }

    return $this->getResource()::getUrl('index');
  }
}
