<?php

namespace App\Service;

use App\Models\ReferralCode;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

  // public function create(array $data, $imageFile = null)
  // {
  //   $worker = Worker::create($data);

  //   if ($imageFile) {
  //     $worker->addMedia($imageFile)->toMediaCollection('workers');
  //   }

  //   return $worker;
  // }


  public function create(array $data, $imageFiles = null)
  {
    return DB::transaction(function () use ($data, $imageFiles) {
      $worker = Worker::create($data);
      if (!empty($data['form_referral_code'])) {
        $referralCode = ReferralCode::where('code', $data['form_referral_code'])
          ->where('is_active', true)
          ->first();
        if ($referralCode && (is_null($referralCode->usage_limit) || $referralCode->times_used < $referralCode->usage_limit)) {
          $referralCode->increment('times_used');
        }
      }
      // if ($imageFile) {
      //   $worker->addMedia($imageFile)->toMediaCollection('workers');
      // }

      if (!empty($imageFiles) && is_array($imageFiles)) {
        foreach ($imageFiles as $file) {
          if ($file) {
            $worker->addMedia($file)->toMediaCollection('workers');
          }
        }
      } elseif ($imageFiles) {
        $worker->addMedia($imageFiles)->toMediaCollection('workers');
      }



      return $worker;
    });
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
