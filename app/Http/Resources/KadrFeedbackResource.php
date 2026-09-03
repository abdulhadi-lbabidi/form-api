<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KadrFeedbackResource extends JsonResource
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
      'kadr_id'           => $this->kadr_id,
      'stars'             => $this->stars,
      'reason'            => $this->reason,
      'feedbackable_type' => $this->feedbackable_type,
      'feedbackable_id'   => $this->feedbackable_id,
      'created_at'        => $this->created_at,
      'updated_at'        => $this->updated_at,

      'kadr'              => new KadrResource($this->whenLoaded('kadr')),
      'feedbackable'      => $this->whenLoaded('feedbackable'),
    ];
  }
}
