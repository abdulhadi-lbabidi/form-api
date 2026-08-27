<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerListResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'phone_whatsapp'       => $this->phone_whatsapp,
      'code'                 => $this->code,
      'age'                  => $this->age,
      'city'                 => $this->city,
      'residential_area'     => $this->residential_area,
      'marital_status'       => $this->marital_status,
      'primary_profession'   => $this->primary_profession,
      'other_professions'    => $this->other_professions,
      'work_hours'           => $this->work_hours,
      'working_status'           => $this->working_status,
      'commitment_level'     => $this->commitment_level,
      'expected_hourly_rate_usd' => $this->expected_hourly_rate_usd,
      'expected_hourly_rate_syp' => $this->expected_hourly_rate_syp,
      'payment_method'       => $this->payment_method,
      'category'       => CategoryResource::collection($this->whenLoaded('category')),
    ];
  }
}
