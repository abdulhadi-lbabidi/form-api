<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferralCodeResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'                => $this->id,
      'code'              => $this->code,
      'usage_limit'       => $this->usage_limit,
      'times_used'        => $this->times_used,
      'expires_at'        => $this->expires_at,
      'is_active'         => (bool) $this->is_active,
      'referralable_id'   => $this->referralable_id,
      'referralable_type' => $this->referralable_type,

      'owner_details'     => $this->whenLoaded('referralable'),

      'created_at'        => $this->created_at?->toIso8601String(),
    ];
  }
}
