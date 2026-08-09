<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Actions;




class EditCompany extends EditRecord
{
  protected static string $resource = CompanyResource::class;

  // protected function getHeaderActions(): array
  // {
  //   return [
  //     Actions\Action::make('back')
  //       ->label('رجوع')
  //       ->color('gray')
  //       ->url($this->getResource()::getUrl('index')),
  //     ViewAction::make(),
  //     DeleteAction::make(),
  //   ];
  // }
  // protected function getRedirectUrl(): string
  // {
  //   return $this->getResource()::getUrl('index');
  // }

  public function mount($record): void
  {
    parent::mount($record);
    if (!session()->has('workers_previous_url')) {
      session()->put('workers_previous_url', url()->previous());
    }
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(fn() => session()->get('workers_previous_url', $this->getResource()::getUrl('index'))),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return session()->get('workers_previous_url', $this->getResource()::getUrl('index'));
  }
  protected function mutateFormDataBeforeFill(array $data): array
  {
    $data['user_email'] = $this->record->user?->email;

    return $data;
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $email = $data['user_email'] ?? null;
    $password = $data['password'] ?? null;

    if ($this->record->user) {
      $updateData = [];
      if (filled($email)) {
        $updateData['email'] = $email;
      }
      if (filled($password)) {
        $updateData['password'] = $password;
      }
      if (!empty($updateData)) {
        $this->record->user->update($updateData);
      }
    } elseif ($email) {
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
