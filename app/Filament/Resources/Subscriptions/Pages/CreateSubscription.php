<?php

namespace App\Filament\Resources\Subscriptions\Pages;

use App\Filament\Resources\Subscriptions\SubscriptionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;


class CreateSubscription extends CreateRecord
{
  protected static string $resource = SubscriptionResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url($this->getResource()::getUrl('index')),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    if (!empty($data['subscribable_combined'])) {
      [$type, $id] = explode(':', $data['subscribable_combined']);
      $data['subscribable_type'] = $type;
      $data['subscribable_id'] = $id;
    }

    unset($data['subscribable_combined']); 

    return $data;
  }
}