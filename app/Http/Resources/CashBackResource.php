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
      'number_of_clicks' => $this->number_of_clicks,
      'redirect_url'     => $this->redirect_url,
      'is_favorite'      => $this->is_favorite,
      'categories'       => CashbackCategoryResource::collection($this->whenLoaded('categories')),
      'created_at'       => $this->created_at?->toDateTimeString(),
    ];
  }
}
