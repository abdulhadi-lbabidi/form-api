<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KadrResource extends JsonResource
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
      'first_name'             => $this->first_name,
      'father_name'            => $this->father_name,
      'last_name'              => $this->last_name,
      'date_of_birth'          => $this->date_of_birth,
      'number_of_person'       => $this->number_of_person,
      'email'                  => $this->email,
      'phone'                  => $this->phone,
      'shop_address'           => $this->shop_address,
      'city'                   => $this->city,
      'residential_area'       => $this->residential_area,
      'service_type'           => $this->service_type,
      'has_team'               => (bool) $this->has_team,
      'social_or_website_link' => $this->social_or_website_link,

      'file'                   => $this->getFirstMediaUrl('kadrs'),

      'all_files'              => $this->getMedia('kadrs')->map(function ($media) {
        return [
          'id'  => $media->id, 
          'url' => $media->getUrl(),
        ];
      }),

      'marketing_sources'      => MarketingSourceResource::collection($this->whenLoaded('marketingSources')),
    ];
  }
}