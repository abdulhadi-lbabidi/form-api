<?php

namespace App\Service;

use App\Models\Time;
use Illuminate\Database\Eloquent\Collection;

class TimeService
{
  public function findAll(): Collection
  {
    return Time::get();
  }

  public function findOne(int $id): Time
  {
    return Time::with('subscriptions')->findOrFail($id);
  }

  public function create(array $data): Time
  {
    return Time::create($data);
  }

  public function update(int $id, array $data): Time
  {
    $time = $this->findOne($id);
    $time->update($data);
    return $time;
  }

  public function delete(int $id): bool
  {
    $time = $this->findOne($id);
    return $time->delete();
  }
}
