<?php

namespace App\Filament\Widgets;


use App\Models\MarketingSource;
use Filament\Widgets\ChartWidget;

class MarketingSourcesChart extends ChartWidget
{

  protected  ?string $heading = 'إحصائيات مصادر التعرف علينا';

  protected static ?int $sort = 2;

  protected function getData(): array
  {
    $sources = MarketingSource::withCount(['companies', 'workers'])->get();

    $labels = $sources->map(fn($source) => $source->translated_name)->toArray();

    $companiesData = $sources->map(fn($source) => $source->companies_count)->toArray();
    $workersData = $sources->map(fn($source) => $source->workers_count)->toArray();

    return [
      'datasets' => [
        [
          'label' => 'الشركات',
          'data' => $companiesData,
          'backgroundColor' => '#1a4a7a',
          'borderColor' => '#1a4a7a',
        ],
        [
          'label' => 'العمال',
          'data' => $workersData,
          'backgroundColor' => '#c9a227',
          'borderColor' => '#c9a227',
        ],
      ],
      'labels' => $labels,

    ];
  }
  protected function getType(): string
  {
    return 'bar';
  }
}
