<?php

namespace App\Service;

use App\Models\Company;
use App\Models\ReferralCode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompanyService
{
  public function findAll(): Collection
  {
    return Company::with('referralCode')->get();
  }

  public function findOne(int $id): Company
  {
    return Company::with('referralCode')->findOrFail($id);
  }
  // public function create(array $data, $imageFile = null)
  // {
  //   $company = Company::create($data);
  //   if ($imageFile) {
  //     $company->addMedia($imageFile)->toMediaCollection('companies');
  //   }
  //   return $company;
  // }


  public function create(array $data, $imageFiles = null)
  {
    return DB::transaction(function () use ($data, $imageFiles) {
      $company = Company::create($data);
      if (!empty($data['form_referral_code'])) {
        $referralCode = ReferralCode::where('code', $data['form_referral_code'])
          ->where('is_active', true)
          ->first();
        if ($referralCode && (is_null($referralCode->usage_limit) || $referralCode->times_used < $referralCode->usage_limit)) {
          $referralCode->increment('times_used');
        }
      }

      if (!empty($imageFiles) && is_array($imageFiles)) {
        foreach ($imageFiles as $file) {
          if ($file) {
            $company->addMedia($file)->toMediaCollection('companies');
          }
        }
      } elseif ($imageFiles) {
        $company->addMedia($imageFiles)->toMediaCollection('companies');
      }

      return $company;
    });
  }



  public function update(Company $company, array $data, $imageFile = null)
  {
    $company->update($data);
    if ($imageFile) {
      $company->clearMediaCollection('companies');
      $company->addMedia($imageFile)->toMediaCollection('companies');
    }
    return $company;
  }




  public function delete(int $id): bool
  {
    $company = $this->findOne($id);
    return $company->delete();
  }
}
