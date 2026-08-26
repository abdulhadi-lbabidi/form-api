<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyJobHostingResource extends JsonResource
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
      'title'            => $this->title,
      'job_type'         => $this->job_type,
      'workers_count'    => $this->workers_count,
      'shift_period'     => $this->shift_period,
      'time_from'        => $this->time_from,
      'time_to'          => $this->time_to,
      'city'             => $this->city,
      'district'         => $this->district,
      'experience_level' => $this->experience_level,
      'salary_min'       => $this->salary_min,
      'salary_max'       => $this->salary_max,
      'currency'         => $this->currency,
      'salary_interval'  => $this->salary_interval,
      'notes'            => $this->notes,
      'status'           => $this->status,
      'company'          => new CompanyResource($this->whenLoaded('company')),
      'created_at'       => $this->created_at?->toIso8601String(),
    ];
  }
}
