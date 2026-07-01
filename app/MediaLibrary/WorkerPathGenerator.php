<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WorkerPathGenerator implements PathGenerator
{
  public function getPath(Media $media): string
  {
    return 'workers/' . $media->id . '/';
  }

  public function getPathForConversions(Media $media): string
  {
    return 'workers/' . $media->id . '/conversions/';
  }

  public function getPathForResponsiveImages(Media $media): string
  {
    return 'workers/' . $media->id . '/responsive/';
  }
}
