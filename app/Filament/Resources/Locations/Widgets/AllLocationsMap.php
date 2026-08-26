<?php

namespace App\Filament\Resources\Locations\Widgets;

use App\Models\Company;
use App\Models\Location;
use App\Models\Worker;
use Filament\Widgets\Widget;

class AllLocationsMap extends Widget
{
  protected string $view = 'filament.resources.locations.widgets.all-locations-map';

  protected int | string | array $columnSpan = 'full';


  // protected function getViewData(): array
  // {
  //   return [
  //     'locations' => Location::all(),
  //   ];
  // }

  protected function getViewData(): array
  {
    $locations = Location::all()->map(function ($location) {
      $workersCount = Worker::where('residential_area', 'like', '%' . $location->name . '%')->count();

      $companiesCount = Company::where('work_location', 'like', '%' . $location->name . '%')->count();

      return [
        'id' => $location->id,
        'name' => $location->name,
        'coordinates' => $location->coordinates,
        'workers_count' => $workersCount,
        'companies_count' => $companiesCount,
      ];
    });

    return [
      'locations' => $locations,
    ];
  }
}
