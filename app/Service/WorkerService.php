<?php

namespace App\Service;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;

class WorkerService
{
  public function findAll(): Collection
  {
    return Worker::with('referralCode')->get();
  }

  public function findOne(int $id): Worker
  {
    return Worker::with('referralCode')->findOrFail($id);
  }

  public function create(array $data): Worker
  {
    return Worker::create($data);
  }

  public function update(int $id, array $data): Worker
  {
    $worker = $this->findOne($id);
    $worker->update($data);
    return $worker;
  }

  public function delete(int $id): bool
  {
    $worker = $this->findOne($id);
    return $worker->delete();
  }
}
