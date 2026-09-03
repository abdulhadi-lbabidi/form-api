<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerFeedbackResource extends JsonResource
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
      'worker_id'         => $this->worker_id,
      'stars'             => $this->stars,
      'reason'            => $this->reason,
      'feedbackable_type' => $this->feedbackable_type,
      'feedbackable_id'   => $this->feedbackable_id,
      'created_at'        => $this->created_at,
      'updated_at'        => $this->updated_at,

      'worker'            => new WorkerResource($this->whenLoaded('worker')),
      'feedbackable'      => $this->whenLoaded('feedbackable'),
    ];
  }
}
