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

  public function create(array $data): Company
  {
    return Company::create($data);
  }

  public function update(int $id, array $data): Company
  {
    $company = $this->findOne($id);
    $company->update($data);
    return $company;
  }

  public function delete(int $id): bool
  {
    $company = $this->findOne($id);
    return $company->delete();
  }
}
