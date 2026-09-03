<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyFeedbackResource extends JsonResource
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
      'company_id'        => $this->company_id,
      'stars'             => $this->stars,
      'reason'            => $this->reason,
      'feedbackable_type' => $this->feedbackable_type,
      'feedbackable_id'   => $this->feedbackable_id,
      'created_at'        => $this->created_at,
      'updated_at'        => $this->updated_at,

      'company'           => new CompanyResource($this->whenLoaded('company')),
      'feedbackable'      => $this->whenLoaded('feedbackable'),
    ];
  }
}
