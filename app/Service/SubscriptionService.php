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
      ->whereIn('status', ['active', 'pending'])
      ->whereDate('created_at', now()->toDateString())
      ->exists();

    if ($isBooked) {
      throw ValidationException::withMessages([
        'time_id' => ['الفترة الزمنية المختارة غير متاحة حالياً لأنها محجوزة.'],
      ]);
    }
    return Subscription::create($data);
  }

  public function update(int $id, array $data): Subscription
  {
    $subscription = $this->findOne($id);
    $subscription->update($data);
    return $subscription;
  }

  public function delete(int $id): bool
  {
    $subscription = $this->findOne($id);
    return $subscription->delete();
  }
}
