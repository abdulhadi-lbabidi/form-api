<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KadrJobHostingResource extends JsonResource
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
      'time_from'        => $this->is_visible_time ? $this->time_from : null,
      'time_to'          => $this->is_visible_time ? $this->time_to : null,
      'city'             => $this->city,
      'district'         => $this->district,
      'experience_level' => $this->experience_level,
      'salary_min'       => $this->is_visible_salary ? $this->salary_min : null,
      'salary_max'       => $this->is_visible_salary ? $this->salary_max : null,
      'currency'         => $this->currency,
      'salary_interval'  => $this->salary_interval,
      'created_at'       => $this->created_at?->toIso8601String(),
    ];
  }
}
