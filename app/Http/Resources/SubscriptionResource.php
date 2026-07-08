<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'         => $this->id,
      'status'     => $this->status,
      'note'       => $this->note,
      'phone_number' => $this->phone_number,
      'time_id'    => $this->time_id,
      'date'       => $this->date,
      'time'       => new TimeResource($this->whenLoaded('time')),

      'created_at' => $this->created_at?->toIso8601String(),
    ];
  }
}
