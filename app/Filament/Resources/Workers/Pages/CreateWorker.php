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

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $email = $data['user_email'] ?? null;
    $password = $data['password'] ?? null;
    $phone_number = $data['phone_whatsapp'] ?? null;

    if (filled($phone_number) && User::where('phone_number', $phone_number)->exists()) {
      throw ValidationException::withMessages([
        'data.phone_whatsapp' => 'رقم الهاتف هذا مستخدم مسبقاً لحساب آخر في النظام.',
      ]);
    }

    if (filled($email) && User::where('email', $email)->exists()) {
      throw ValidationException::withMessages([
        'data.user_email' => 'البريد الإلكتروني هذا مستخدم مسبقاً لحساب آخر في النظام.',
      ]);
    }

    DB::transaction(function () use (&$data, $email, $password, $phone_number) {
      if ($email) {
        $workerName = $data['full_name'] ?? (($data['first_name'] ?? 'عامل') . ' ' . ($data['last_name'] ?? 'جديد'));

        $user = User::create([
          'name'         => $workerName,
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
