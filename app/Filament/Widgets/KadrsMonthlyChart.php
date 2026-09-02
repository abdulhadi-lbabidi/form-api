<?php

namespace App\Filament\Widgets;

use App\Models\Kadr;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KadrsMonthlyChart extends ChartWidget
{
  protected ?string $heading = 'نمو تسجيل الكوادر الشهري';

  protected static ?int $sort = 5;

  public ?string $filter = null;

  public static function canView(): bool
  {
    return auth()->user()->hasRole('super_admin') || auth()->user()->can('view_kadrs_monthly_chart');
  }

  protected function getFilters(): ?array
  {
    $years = Kadr::selectRaw('YEAR(created_at) as year')
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

    $kadrsByMonth = Kadr::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('COUNT(*) as total')
    )
      ->whereYear('created_at', $activeYear)
      ->groupBy('month')
      ->pluck('total', 'month')
      ->toArray();

    $data = [];
    for ($m = 1; $m <= 12; $m++) {
      $data[] = $kadrsByMonth[$m] ?? 0;
    }

    return [
      'datasets' => [
        [
          'label' => "إجمالي الكوادر المسجلة لعام {$activeYear}",
          'data' => $data,
          'fill' => 'start',
          'borderColor' => '#8b5cf6',
          'backgroundColor' => 'rgba(139, 92, 246, 0.15)',
          'tension' => 0.4,
          'pointRadius' => 5,
          'pointHoverRadius' => 7,
          'pointBackgroundColor' => '#7c3aed',
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
