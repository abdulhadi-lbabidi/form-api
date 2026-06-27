<?php

namespace  App\Service;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class   CompanyService
{

  public function findAll(): Collection {}

  public function findOne(int $id): Company {}

  public function create(array $data): Company {}

  public function update(int $id, array $data): Company {}

  public function delete(int $id): bool {}
}
