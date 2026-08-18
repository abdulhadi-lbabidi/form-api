<?php

namespace App\Service;

use App\Models\Company;
use App\Models\Worker;
use Illuminate\Support\Facades\Hash;

class AuthService
{
  public function loginUser(array $data)
  {
    $type  = $data['type'];
    $login = $data['login'];

    $user = null;

    if ($type === 'company') {
      $user = Company::where('phone_number', $login)
        ->orWhere('email', $login)
        ->first();
    } elseif ($type === 'worker') {
      $user = Worker::where('phone_whatsapp', $login)
        ->orWhere('email', $login)
        ->first();
    }

    if (!$user || !Hash::check($data['password'], $user->password)) {
      return null;
    }

    $token = $user->createToken($type . '_auth_token')->plainTextToken;

    return [
      'token' => $token,
      'user'  => $user,
      'type'  => $type
    ];
  }

  public function updatePassword(array $data): bool
  {
    $type  = $data['type'] ?? 'worker';
    $login = $data['login'];

    $user = null;
    if ($type === 'company') {
      $user = Company::where('phone_number', $login)->orWhere('email', $login)->first();
    } else {
      $user = Worker::where('phone_whatsapp', $login)->orWhere('email', $login)->first();
    }

    if (!$user) {
      return false;
    }

    $user->password = Hash::make($data['password']);
    $user->save();

    $user->tokens()->delete();

    return true;
  }
}
