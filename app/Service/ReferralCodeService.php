<?php

namespace App\Service;

use App\Models\ReferralCode;
use Illuminate\Database\Eloquent\Collection;

class ReferralCodeService
{
  public function findAll(): Collection
  {
    return ReferralCode::with('referralable')->get();
  }

  public function findOne(int $id): ReferralCode
  {
    return ReferralCode::with('referralable')->findOrFail($id);
  }

  public function create(array $data): ReferralCode
  {
    return ReferralCode::create($data);
  }

  public function update(int $id, array $data): ReferralCode
  {
    $referralCode = $this->findOne($id);
    $referralCode->update($data);
    return $referralCode;
  }

  public function delete(int $id): bool
  {
    $referralCode = $this->findOne($id);
    return $referralCode->delete();
  }
}
