<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'            => $this->id,
      'work_time'     => $this->work_time,
      'subscriptions' => SubscriptionResource::collection($this->whenLoaded('subscriptions')),
      'created_at'    => $this->created_at?->toIso8601String(),
    ];
  }
}
