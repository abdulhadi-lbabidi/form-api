<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashBackResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'               => $this->id,
      'company_name'     => $this->company_name,
      'reasone'          => $this->reasone,
      'owner_name'       => $this->owner_name,
      'phone_number'     => $this->phone_number,
      'cashbackable'     => $this->whenLoaded('cashbackable'),
      'categories'       => CashbackCategoryResource::collection($this->whenLoaded('categories')),
      'created_at'       => $this->created_at?->toDateTimeString(),
    ];
  }
}
