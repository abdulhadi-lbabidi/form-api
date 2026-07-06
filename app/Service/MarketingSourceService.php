<?php


namespace App\Service;

use App\Models\MarketingSource;
use Illuminate\Support\Collection;

class MarketingSourceService
{

  public function findAll(): Collection
  {
    return MarketingSource::get();
  }

  public function findOne(int $id): MarketingSource
  {
    return MarketingSource::findOrFail($id);
  }

  public function create(array $data): MarketingSource
  {
    return MarketingSource::create($data);
  }

  public function update(int $id, array $data): MarketingSource
  {
    $marketingResource = $this->findOne($id);
    $marketingResource->update($data);
    return $marketingResource;
  }

  public function delete(int $id): bool
  {
    $marketingResource = $this->findOne($id);
    return $marketingResource->delete();
  }
}
