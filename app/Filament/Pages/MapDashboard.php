<?php

namespace App\Filament\Pages;

use App\Models\Company;
use App\Models\Kadr;
use App\Models\Location;
use App\Models\Worker;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class MapDashboard extends Page
{
  use HasPageShield;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map';
  protected static ?string $navigationLabel = 'خريطة توزع العمال والشركات والكوادر';

  protected string $view = 'filament.pages.map-dashboard';



  public ?string $selectedCity = null;
  public array $cityCounts = [];

  public int $workersLimit = 15;
  public int $companiesLimit = 15;
  public int $kadrsLimit = 15;

  public function selectCity(string $cityName): void
  {
    $this->selectedCity = $cityName;

    $this->workersLimit = 15;
    $this->companiesLimit = 15;
    $this->kadrsLimit = 15;

    $this->cityCounts = [
      'workers' => Worker::where('residential_area', 'like', '%' . $cityName . '%')->count(),
      'companies' => Company::where('work_location', 'like', '%' . $cityName . '%')->count(),
      'kadrs' => Kadr::where('shop_address', 'like', '%' . $cityName . '%')->count(),
    ];
  }

  public function loadMoreWorkers(): void
  {
    $this->workersLimit += 15;
  }

  public function loadMoreCompanies(): void
  {
    $this->companiesLimit += 15;
  }

  public function loadMoreKadrs(): void
  {
    $this->kadrsLimit += 15;
  }

  public function getWorkersProperty()
  {
    if (!$this->selectedCity) return collect();
    return Worker::where('residential_area', 'like', '%' . $this->selectedCity . '%')
      ->take($this->workersLimit)->get();
  }

  public function getCompaniesProperty()
  {
    if (!$this->selectedCity) return collect();
    return Company::where('work_location', 'like', '%' . $this->selectedCity . '%')
      ->take($this->companiesLimit)->get();
  }

  public function getKadrsProperty()
  {
    if (!$this->selectedCity) return collect();
    return Kadr::where('shop_address', 'like', '%' . $this->selectedCity . '%')
      ->take($this->kadrsLimit)->get();
  }

  protected function getViewData(): array
  {
    return [
      'locations' => Location::all()->map(function ($location) {
        return [
          'name' => $location->name,
          'coordinates' => $location->coordinates,
          'workers_count' => Worker::where('residential_area', 'like', '%' . $location->name . '%')->count(),
          'companies_count' => Company::where('work_location', 'like', '%' . $location->name . '%')->count(),
          'kadrs_count' => Kadr::where('shop_address', 'like', '%' . $location->name . '%')->count(),
        ];
      })->toArray(),
    ];
  }
}
