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

  public function create(array $data, $imageFile = null)
  {
    $worker = Worker::create($data);

    if ($imageFile) {
      $worker->addMedia($imageFile)->toMediaCollection('workers');
    }

    return $worker;
  }

  public function update(Worker $worker, array $data, $imageFile = null)
  {
    $worker->update($data);

    if ($imageFile) {
      $worker->clearMediaCollection('workers');
      $worker->addMedia($imageFile)->toMediaCollection('workers');
    }

    return $worker;
  }

  public function delete(int $id): bool
  {
    $worker = $this->findOne($id);
    return $worker->delete();
  }
}
