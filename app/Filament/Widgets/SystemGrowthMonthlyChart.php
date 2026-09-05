<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Kadr;
use App\Models\Worker;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SystemGrowthMonthlyChart extends ChartWidget
{
  protected ?string $heading = 'نمو التسجيل الشهري (العمال، الكوادر، الشركات)';
  protected static ?int $sort = 3;
  public ?string $filter = null;

  public static function canView(): bool
  {
    return auth()->user()->hasRole('super_admin')
      || auth()->user()->can('view_workers_monthly_chart')
      || auth()->user()->can('view_kadrs_monthly_chart')
      || auth()->user()->can('view_companies_monthly_chart');
  }

  protected function getFilters(): ?array
  {
    $workerYears = Worker::selectRaw('YEAR(created_at) as year')->pluck('year');
    $kadrYears = Kadr::selectRaw('YEAR(created_at) as year')->pluck('year');
    $companyYears = Company::selectRaw('YEAR(created_at) as year')->pluck('year');

    $years = $workerYears->merge($kadrYears)->merge($companyYears)->unique()->sortDesc()->toArray();

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

    $workersData = Worker::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('COUNT(*) as total')
    )
      ->whereYear('created_at', $activeYear)
      ->groupBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $kadrsData = Kadr::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('COUNT(*) as total')
    )
      ->whereYear('created_at', $activeYear)
      ->groupBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $companiesData = Company::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('COUNT(*) as total')
    )
      ->whereYear('created_at', $activeYear)
      ->groupBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $workersMonthly = [];
    $kadrsMonthly = [];
    $companiesMonthly = [];

    for ($m = 1; $m <= 12; $m++) {
      $workersMonthly[] = $workersData[$m] ?? 0;
      $kadrsMonthly[] = $kadrsData[$m] ?? 0;
      $companiesMonthly[] = $companiesData[$m] ?? 0;
    }

    return [
      'datasets' => [
        [
          'label' => "العمال ({$activeYear})",
          'data' => $workersMonthly,
          'borderColor' => '#3b82f6', // أزرق
          'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
          'tension' => 0.4,
        ],
        [
          'label' => "الكوادر ({$activeYear})",
          'data' => $kadrsMonthly,
          'borderColor' => '#8b5cf6', // بنفسجي
          'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
          'tension' => 0.4,
        ],
        [
          'label' => "الشركات ({$activeYear})",
          'data' => $companiesMonthly,
          'borderColor' => '#10b981', // أخضر
          'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
          'tension' => 0.4,
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