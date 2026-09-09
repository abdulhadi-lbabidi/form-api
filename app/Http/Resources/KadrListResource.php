<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KadrListResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id'                     => $this->id,
      'name'                   => $this->name,
      'number_of_person'       => $this->number_of_person,
      'shop_address'           => $this->shop_address,
      'city'                   => $this->city,
      'residential_area'       => $this->residential_area,
      'service_type'           => $this->service_type,
      'has_team'               => (bool) $this->has_team,
      'social_or_website_link' => $this->social_or_website_link,
      'marketing_sources'      => MarketingSourceResource::collection($this->whenLoaded('marketingSources')),
    ];
  }
}
