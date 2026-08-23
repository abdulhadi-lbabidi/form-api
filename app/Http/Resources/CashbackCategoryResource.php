<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashbackCategoryResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'             => $this->id,
      'name'           => $this->name,
      'description'    => $this->description,
      'cashbacks_count' => $this->whenHas('cashbacks_count'),
      'cashbacks'      => CashBackResource::collection($this->whenLoaded('cashbacks')),
      'created_at'     => $this->created_at?->toDateTimeString(),
    ];
  }
}
