<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplyJobResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'           => $this->id,
      'worker_id'    => $this->worker_id,
      'worker'       => new WorkerListResource($this->whenLoaded('worker')),
      'jobable_type' => $this->jobable_type,
      'jobable_id'   => $this->jobable_id,
      'job'          => $this->whenLoaded('jobable'),
      'status'       => $this->status,
      'notes'        => $this->notes,
      'created_at'   => $this->created_at?->toIso8601String(),
    ];
  }
}
