<?php

namespace App\Filament\Widgets;

use App\Models\MarketingSource;
use Filament\Widgets\ChartWidget;

class MarketingSourcesChart extends ChartWidget
{
  protected ?string $heading = 'إحصائيات مصادر التعرف علينا';

  protected static ?int $sort = 2;

  public static function canView(): bool
  {
    return auth()->user()->hasRole('super_admin') || auth()->user()->can('view_marketing_sources_chart');
  }

  protected function getData(): array
  {
    // جلب المصادر مع عد الشركات، العمال، والكوادر
    $sources = MarketingSource::withCount(['companies', 'workers', 'kadrs'])->get();

    $labels = $sources->map(fn($source) => $source->translated_name)->toArray();

    $companiesData = $sources->map(fn($source) => $source->companies_count)->toArray();
    $workersData = $sources->map(fn($source) => $source->workers_count)->toArray();
    $kadrsData = $sources->map(fn($source) => $source->kadrs_count)->toArray();

    return [
      'datasets' => [
        [
          'label' => 'الشركات',
          'data' => $companiesData,
          'borderColor' => '#10b981',
          'backgroundColor' => '#10b981',
        ],
        [
          'label' => 'العمال',
          'data' => $workersData,
          'borderColor' => '#3b82f6',
          'backgroundColor' => '#3b82f6',
        ],
        [
          'label' => 'الكوادر',
          'data' => $kadrsData,
          'borderColor' => '#8b5cf6',
          'backgroundColor' => '#8b5cf6',
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