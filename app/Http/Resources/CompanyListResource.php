<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MarketingSourceResource;

class CompanyListResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'             => $this->id,
      'company_name'   => $this->company_name,
      'business_type'  => $this->business_type,
      'problems_faced' => $this->problems_faced,
      'work_location'  => $this->work_location,
      'city'           => $this->city,
      'form_referral_code' => $this->form_referral_code,
      'marketing_sources' => MarketingSourceResource::collection($this->whenLoaded('marketingSources')),
      'referral_code'  => new ReferralCodeResource($this->whenLoaded('referralCode')),
      'created_at'     => $this->created_at?->toIso8601String(),
    ];
  }
}
