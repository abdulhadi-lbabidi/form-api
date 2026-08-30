<?php

namespace App\Filament\Resources\Locations\Widgets;

use App\Models\Company;
use App\Models\Kadr;
use App\Models\Location;
use App\Models\Worker;
use Filament\Widgets\Widget;

class AllLocationsMap extends Widget
{
  protected string $view = 'filament.resources.locations.widgets.all-locations-map';

  protected int | string | array $columnSpan = 'full';

  protected function getViewData(): array
  {
    $locations = Location::all()->map(function ($location) {
      $workers = Worker::where('residential_area', 'like', '%' . $location->name . '%')
        ->select('id', 'full_name', 'residential_area')
        ->get();

      $companies = Company::where('work_location', 'like', '%' . $location->name . '%')
        ->select('id', 'company_name', 'work_location')
        ->get();

      $kadrs = Kadr::where('shop_address', 'like', '%' . $location->name . '%')
        ->select('id', 'name', 'shop_address')
        ->get();

      return [
        'id' => $location->id,
        'name' => $location->name,
        'coordinates' => $location->coordinates,
        'workers_count' => $workers->count(),
        'companies_count' => $companies->count(),
        'kadrs_count' => $kadrs->count(),
        'workers' => $workers,
        'companies' => $companies,
        'kadrs' => $kadrs,
      ];
    });

    return [
      'locations' => $locations,
    ];
  }
}
