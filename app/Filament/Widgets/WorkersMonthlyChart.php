<?php

namespace App\Filament\Widgets;

use App\Models\Worker;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WorkersMonthlyChart extends ChartWidget
{
  protected ?string $heading = 'نمو تسجيل العمال الشهري';

  protected static ?int $sort = 3;

  public ?string $filter = null;

  public static function canView(): bool
  {
    return auth()->user()->hasRole('super_admin') || auth()->user()->can('view_workers_monthly_chart');
  }

  protected function getFilters(): ?array
  {
    $years = Worker::selectRaw('YEAR(created_at) as year')
      ->distinct()
      ->orderBy('year', 'desc')
      ->pluck('year')
      ->toArray();

    $currentYear = Carbon::now()->year;
    if (empty($years) || !in_array($currentYear, $years)) {
      $years[] = $currentYear;
    }

    rsort($years);

    return array_combine($years, $years);
  }
  protected function getData(): array
  {
    $activeYear = $this->filter ?? Carbon::now()->year;

    $months = [
      'يناير',
      'فبراير',
      'مارس',
      'أبريل',
      'مايو',
      'يونيو',
      'يوليو',
      'أغسطس',
      'سبتمبر',
      'أكتوبر',
      'نوفمبر',
      'ديسمبر'
    ];

    $workersByMonth = Worker::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('COUNT(*) as total')
    )
      ->whereYear('created_at', $activeYear)
      ->groupBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $data = [];
    for ($m = 1; $m <= 12; $m++) {
      $data[] = $workersByMonth[$m] ?? 0;
    }

    return [
      'datasets' => [
        [
          'label' => "إجمالي العمال المسجلين لعام {$activeYear}",
          'data' => $data,
          'fill' => 'start',
          'borderColor' => '#3b82f6',
          'backgroundColor' => 'rgba(59, 130, 246, 0.15)',
          'tension' => 0.4,
          'pointRadius' => 5,
          'pointHoverRadius' => 7,
          'pointBackgroundColor' => '#1d4ed8',
        ],
      ],
      'labels' => $months,
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }
}
