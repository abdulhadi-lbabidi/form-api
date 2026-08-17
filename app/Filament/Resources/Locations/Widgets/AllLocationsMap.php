<?php

namespace App\Filament\Resources\Locations\Widgets;

use App\Models\Location;
use Filament\Widgets\Widget;

class AllLocationsMap extends Widget
{
  protected string $view = 'filament.resources.locations.widgets.all-locations-map';

  protected int | string | array $columnSpan = 'full';


  protected function getViewData(): array
  {
    return [
      'locations' => Location::all(),
    ];
  }
}
