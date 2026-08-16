<?php

namespace App\Filament\Resources\Workers\Pages;

use App\Filament\Resources\Workers\WorkerResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EditWorker extends EditRecord
{
  protected static string $resource = WorkerResource::class;

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
    $phone_whatsapp = $data['phone_whatsapp'] ?? null;

    if (filled($phone_whatsapp)) {
      $exists = User::where('phone_number', $phone_whatsapp)
        ->when($this->record->user_id, fn($q) => $q->where('id', '!=', $this->record->user_id))
        ->exists();

      if ($exists) {
        throw ValidationException::withMessages([
          'data.phone_whatsapp' => 'رقم الهاتف هذا مستخدم مسبقاً لحساب آخر في النظام.',
        ]);
      }
    }

    if (filled($email)) {
      $exists = User::where('email', $email)
        ->when($this->record->user_id, fn($q) => $q->where('id', '!=', $this->record->user_id))
        ->exists();

      if ($exists) {
        throw ValidationException::withMessages([
          'data.user_email' => 'البريد الإلكتروني هذا مستخدم مسبقاً لحساب آخر في النظام.',
        ]);
      }
    }

    DB::transaction(function () use (&$data, $email, $password, $phone_whatsapp) {
      if ($this->record->user) {
        $updateData = [];

        if (filled($email)) {
          $updateData['email'] = $email;
        }
        if (filled($password)) {
          $updateData['password'] = $password;
        }
        if (filled($phone_whatsapp)) {
          $updateData['phone_number'] = $phone_whatsapp;
        }

        if (!empty($updateData)) {
          $this->record->user->update($updateData);
        }
      } elseif ($email) {
        $workerName = $data['full_name'] ?? (($data['first_name'] ?? 'عامل') . ' ' . ($data['last_name'] ?? 'جديد'));

        $user = User::create([
          'name'         => $workerName,
          'email'        => $email,
          'phone_number' => $phone_whatsapp,
          'password'     => filled($password) ? $password : Hash::make('password'),
        ]);
        $data['user_id'] = $user->id;
      }
    });

    unset($data['user_email'], $data['password']);

    return $data;
  }
}
