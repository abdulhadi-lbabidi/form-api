<?php

namespace App\Service;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

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


  public function create(array $data, $imageFile = null)
  {
    $company = Company::create($data);
    if ($imageFile) {
      $company->addMedia($imageFile)->toMediaCollection('companies');
    }
    return $company;
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
