<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CashbackPathGenerator implements PathGenerator
{
  public function getPath(Media $media): string
  {
    return 'images_content_deals/' . $media->id . '/';
  }

  public function getPathForConversions(Media $media): string
  {
    return 'images_content_deals/' . $media->id . '/conversions/';
  }

  public function getPathForResponsiveImages(Media $media): string
  {
    return 'images_content_deals/' . $media->id . '/responsive/';
  }
}
