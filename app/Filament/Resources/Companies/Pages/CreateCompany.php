<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use Illuminate\Support\Facades\Hash;

class CreateCompany extends CreateRecord
{
  protected static string $resource = CompanyResource::class;
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
    $email = $data['user_email'] ?? null;
    $password = $data['password'] ?? null;

    if ($email) {
      $companyName = $data['company_name'] ?? 'شركة جديدة';

      $user = User::create([
        'name'     => $companyName,
        'email'    => $email,
        'password' => filled($password) ? $password : Hash::make('password'),
      ]);

      $data['user_id'] = $user->id;
    }

    unset($data['user_email'], $data['password']);

    return $data;
  }
}
