<?php

namespace App\Filament\Widgets;

use App\Models\Worker;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class WorkersStatusChart extends ChartWidget
{
  protected ?string $heading = 'إحصائيات حالات العمال خلال شهور السنة';

  protected static ?int $sort = 2;

  public static function canView(): bool
  {
    return auth()->user()->hasRole('super_admin') || auth()->user()->can('view_workers_status_chart');
  }

  protected function getData(): array
  {
    $currentYear = Carbon::now()->year;

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

    $statuses = [
      'new_registered' => ['label' => 'مسجّل جديد', 'color' => '#3b82f6'],
      'contacted'      => ['label' => 'تم التواصل', 'color' => '#6366f1'],
      'verified'       => ['label' => 'تم التوثيق', 'color' => '#10b981'],
      'job_hunting'    => ['label' => 'في مرحلة البحث عن عمل', 'color' => '#f59e0b'],
      'sent_to_client' => ['label' => 'تم إرساله إلى صاحب العمل', 'color' => '#ec4899'],
      'hired'          => ['label' => 'تم التوظيف', 'color' => '#8b5cf6'],
      'working_now'    => ['label' => 'على رأس عمله', 'color' => '#14b8a6'],
      'frozen'         => ['label' => 'مجمد / غير متاح', 'color' => '#64748b'],
      'blocked'        => ['label' => 'محظور - غير كفوء', 'color' => '#ef4444'],
    ];

    $datasets = [];

    foreach ($statuses as $statusKey => $statusInfo) {
      $monthlyData = [];

      for ($i = 1; $i <= 12; $i++) {
        $monthlyData[] = Worker::whereYear('created_at', $currentYear)
          ->whereMonth('created_at', $i)
          ->where('worker_status', $statusKey)
          ->count();
      }

      $datasets[] = [
        'label' => $statusInfo['label'],
        'data' => $monthlyData,
        'backgroundColor' => $statusInfo['color'],
        'borderColor' => $statusInfo['color'],
      ];
    }

    return [
      'datasets' => $datasets,
      'labels' => $months,
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }
}
