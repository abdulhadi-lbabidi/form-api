<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Service\LocationService;

class LocationController extends Controller
{
  public function __construct(
    private LocationService $locationService
  ) {}

  public function index()
  {
    $locations = $this->locationService->findAll();
    return LocationResource::collection($locations);
  }
}
