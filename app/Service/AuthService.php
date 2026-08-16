<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
  public function loginUser(array $data)
  {
    $user = User::where(function ($query) use ($data) {
      if (!empty($data['email'])) {
        $query->orWhere('email', $data['email']);
      }
      if (!empty($data['phone_number'])) {
        $query->orWhere('phone_number', $data['phone_number']);
      }
    })->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
      return null;
    }

    $token = $user->createToken('auth_token')->plainTextToken;
    return $token;
  }

  public function updatePassword(array $data): bool
  {
    $user = User::where(function ($query) use ($data) {
      if (!empty($data['email'])) {
        $query->orWhere('email', $data['email']);
      }
      if (!empty($data['phone_number'])) {
        $query->orWhere('phone_number', $data['phone_number']);
      }
    })->first();

    if (!$user) {
      return false;
    }

    $user->password = Hash::make($data['password']);
    $user->save();

    $user->tokens()->delete();

    return true;
  }
}
