<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountUpgradeRequestResource extends JsonResource
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
      'notes'      => $this->notes,
      'morphable'  => $this->whenLoaded('morphable'),
      'created_at' => $this->created_at?->toIso8601String(),
    ];
  }
}
