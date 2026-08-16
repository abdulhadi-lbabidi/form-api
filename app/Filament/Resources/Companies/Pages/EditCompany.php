<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
    if (!session()->has('companies_previous_url')) {
      session()->put('companies_previous_url', url()->previous());
    }
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\Action::make('back')
        ->label('رجوع')
        ->color('gray')
        ->url(fn() => session()->get('companies_previous_url', $this->getResource()::getUrl('index'))),
      ViewAction::make(),
      DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return session()->get('companies_previous_url', $this->getResource()::getUrl('index'));
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
    $phone_number = $data['phone_number'] ?? null;

    if (filled($phone_number)) {
      $exists = User::where('phone_number', $phone_number)
        ->when($this->record->user_id, fn($q) => $q->where('id', '!=', $this->record->user_id))
        ->exists();
      if ($exists) {
        throw ValidationException::withMessages(['data.phone_number' => 'رقم الهاتف هذا مستخدم مسبقاً لحساب آخر.']);
      }
    }

    if (filled($email)) {
      $exists = User::where('email', $email)
        ->when($this->record->user_id, fn($q) => $q->where('id', '!=', $this->record->user_id))
        ->exists();
      if ($exists) {
        throw ValidationException::withMessages(['data.user_email' => 'البريد الإلكتروني هذا مستخدم مسبقاً لحساب آخر.']);
      }
    }

    DB::transaction(function () use (&$data, $email, $password, $phone_number) {
      if ($this->record->user) {
        $updateData = [];
        if (filled($email)) $updateData['email'] = $email;
        if (filled($password)) $updateData['password'] = $password;
        if (filled($phone_number)) $updateData['phone_number'] = $phone_number;

        if (!empty($updateData)) {
          $this->record->user->update($updateData);
        }
      } elseif ($email) {
        $companyName = $data['company_name'] ?? 'شركة جديدة';
        $user = User::create([
          'name'         => $companyName,
          'email'        => $email,
          'phone_number' => $phone_number,
          'password'     => filled($password) ? $password : Hash::make('password'),
        ]);
        $data['user_id'] = $user->id;
      }
    });

    unset($data['user_email'], $data['password']);

    return $data;
  }
}
