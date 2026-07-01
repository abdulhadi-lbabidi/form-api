<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'                   => $this->id,
      'first_name'           => $this->first_name,
      'last_name'            => $this->last_name,
      'full_name'            => "{$this->first_name} {$this->last_name}",
      'father_name'          => $this->father_name,
      'mother_fullname'      => $this->mother_fullname,
      'phone_whatsapp'       => $this->phone_whatsapp,
      'age'                  => $this->age,
      'city'                 => $this->city,
      'residential_area'     => $this->residential_area,
      'marital_status'       => $this->marital_status,
      'primary_profession'   => $this->primary_profession,
      'other_professions'    => $this->other_professions,
      'work_hours'           => $this->work_hours,
      'commitment_level'     => $this->commitment_level,
      'expected_hourly_rate' => $this->expected_hourly_rate,
      'currency'             => $this->currency,
      'payment_method'       => $this->payment_method,

      'referral_code'        => new ReferralCodeResource($this->whenLoaded('referralCode')),

      'file' => $this->getFirstMediaUrl('workers', 'default'),
      'all_files' => $this->getMedia('workers')->map(function ($media) {
        return $media->getUrl('default');
      }),


      'created_at'           => $this->created_at?->toIso8601String(),
    ];
  }
}
