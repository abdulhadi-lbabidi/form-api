<?php

namespace App\Service;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class SubscriptionService
{
  public function findAll(): Collection
  {
    return Subscription::with('time')->get();
  }

  public function findOne(int $id): Subscription
  {
    return Subscription::with('time')->findOrFail($id);
  }

  public function create(array $data): Subscription
  {
    $isBooked = Subscription::where('time_id', $data['time_id'])
      ->where('date', $data['date'])
      ->whereIn('status', ['active', 'pending'])
      ->exists();

    if ($isBooked) {
      throw ValidationException::withMessages([
        'time_id' => ['الفترة الزمنية المختارة غير متاحة في هذا التاريخ لأنها محجوزة.'],
      ]);
    }
    return Subscription::create($data);
  }

  public function update(int $id, array $data): Subscription
  {
    $subscription = $this->findOne($id);

    if (isset($data['time_id']) || isset($data['date'])) {
      $timeId = $data['time_id'] ?? $subscription->time_id;
      $date   = $data['date'] ?? $subscription->date;

      $isBooked = Subscription::where('time_id', $timeId)
        ->where('date', $date)
        ->where('id', '!=', $id)  
        ->whereIn('status', ['active', 'pending'])
        ->exists();

      if ($isBooked) {
        throw ValidationException::withMessages([
          'time_id' => ['الفترة الزمنية المختارة غير متاحة في هذا التاريخ لأنها محجوزة.'],
        ]);
      }
    }

    $subscription->update($data);
    return $subscription;
  }

  public function delete(int $id): bool
  {
    $subscription = $this->findOne($id);
    return $subscription->delete();
  }
}