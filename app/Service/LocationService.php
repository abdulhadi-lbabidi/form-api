<?php

namespace App\Service;

use App\Models\Location;

class LocationService
{

  public function findAll()
  {
    return Location::get();
  }
}
