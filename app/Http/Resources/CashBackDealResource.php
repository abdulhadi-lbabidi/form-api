<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashBackDealResource extends JsonResource
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
      'title'          => $this->title,
      'content'        => $this->content,
      'images_content' => $this->images_content,
      'status'         => $this->status,
      'start_date'     => $this->start_date?->toDateString(),
      'end_date'       => $this->end_date?->toDateString(),

      'media'          => $this->getMedia('cashback-deals')->map(fn($media) => [
        'id'        => $media->id,
        'url'       => $media->getFullUrl(),
        'thumbnail' => $media->hasGeneratedConversion('default') ? $media->getFullUrl('default') : null,
      ]),

      'cashback'       => new CashBackResource($this->whenLoaded('cashback')),

      'created_at'     => $this->created_at?->toDateTimeString(),
    ];
  }
}
