<?php

namespace App\Filament\Resources\Companies\Pages;

use App\Filament\Resources\Companies\CompanyResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateCompany extends CreateRecord
{
  protected static string $resource = CompanyResource::class;
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
    $phone_number = $data['phone_number'] ?? null;

    // التحقق من وجود الهاتف
    if (filled($phone_number) && User::where('phone_number', $phone_number)->exists()) {
      throw ValidationException::withMessages(['data.phone_number' => 'رقم الهاتف هذا مستخدم مسبقاً لحساب آخر.']);
    }

    // التحقق من وجود الإيميل
    if (filled($email) && User::where('email', $email)->exists()) {
      throw ValidationException::withMessages(['data.user_email' => 'البريد الإلكتروني هذا مستخدم مسبقاً لحساب آخر.']);
    }

    DB::transaction(function () use (&$data, $email, $password, $phone_number) {
      if ($email) {
        $companyName = $data['company_name'] ?? 'شركة جديدة';
        $user = User::create([
          'name'         => $companyName,
          'email'        => $email,
          'phone_number' => $phone_number,
          // يتم الاعتماد على تشفير الـ Form إذا تم إدخال كلمة مرور، وإلا كلمة افتراضية
          'password'     => filled($password) ? $password : Hash::make('password'),
        ]);

        $data['user_id'] = $user->id;
      }
    });

    unset($data['user_email'], $data['password']);

    return $data;
  }
}