<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Worker;
use App\Models\Subscription;
use App\Models\ApplyJob;
use App\Models\CompanyJobHosting;
use App\Models\Kadr;
use App\Models\KadrJobHosting;
use App\Models\AccountUpgradeRequest;
use App\Models\AccountUpgraded;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
  protected ?string $pollingInterval = '15s';

  // تحديد عدد الأعمدة في الصف الواحد لتصبح 4 كروت
  protected function getColumns(): int | array
  {
    return [
      'default' => 1,
      'md' => 2,
      'xl' => 4,
    ];
  }

  public static function canView(): bool
  {
    return auth()->user()->hasRole('super_admin') || auth()->user()->can('view_stats_overview');
  }

  protected function getStats(): array
  {
    $companiesCount = Company::count();
    $workersCount = Worker::count();
    $kadrsCount = Kadr::count();

    $companyJobsCount = CompanyJobHosting::count();
    $kadrJobsCount = KadrJobHosting::count();
    $totalJobsCount = $companyJobsCount + $kadrJobsCount;

    $totalApplyJobs = ApplyJob::count();
    $pendingApplyJobs = ApplyJob::where('status', 'pending')->count();
    $companyApplyJobs = ApplyJob::where('jobable_type', CompanyJobHosting::class)->count();
    $kadrApplyJobs = ApplyJob::where('jobable_type', KadrJobHosting::class)->count();

    $activeSubscriptions = Subscription::where('status', 'active')->count();
    $pendingSubscriptions = Subscription::where('status', 'pending')->count();

    $pendingUpgradeRequests = AccountUpgradeRequest::where('status', 'pending')->count();
    $activeUpgradesCount = AccountUpgraded::where('status', 'active')->count();

    $cleanCardStyle = [
      'style' => '
        font-variant-numeric: lnum;
        font-family: cairo, sans-serif;
        position: relative;
        overflow: hidden;
      ',
    ];

    return [
      Stat::make('إجمالي الشركات', $companiesCount)
        ->description('الشركات المسجلة')
        ->descriptionIcon('heroicon-m-building-office-2')
        ->color('info')
        ->url(route('filament.admin.resources.companies.index'))
        ->chart([4, 7, 5, 9, 6, 12, $companiesCount])
        ->extraAttributes($cleanCardStyle),

      Stat::make('إجمالي العمال', $workersCount)
        ->description('العمال المسجلين')
        ->descriptionIcon('heroicon-m-users')
        ->color('purple')
        ->url(route('filament.admin.resources.workers.index'))
        ->chart([5, 8, 12, 10, 15, 20, $workersCount])
        ->extraAttributes($cleanCardStyle),

      Stat::make('إجمالي الكوادر', $kadrsCount)
        ->description('الكوادر المسجلة')
        ->descriptionIcon('heroicon-m-user-group')
        ->color('success')
        ->url(route('filament.admin.resources.kadrs.index'))
        ->chart([2, 5, 8, 7, 11, 14, $kadrsCount])
        ->extraAttributes($cleanCardStyle),

      Stat::make('الوظائف الشاغرة', $totalJobsCount)
        ->description("شركة: {$companyJobsCount} | كادر: {$kadrJobsCount}")
        ->descriptionIcon('heroicon-m-briefcase')
        ->color('success')
        ->chart([10, 15, 12, 18, 22, 25, $totalJobsCount])
        ->extraAttributes($cleanCardStyle),

      Stat::make('طلبات التقديم على الشواغر', $totalApplyJobs)
        ->description("ش: {$companyApplyJobs} | ك: {$kadrApplyJobs} | انتظار: {$pendingApplyJobs}")
        ->descriptionIcon('heroicon-m-document-text')
        ->color($pendingApplyJobs > 0 ? 'warning' : 'success')
        ->url(route('filament.admin.resources.apply-jobs.index'))
        ->chart([8, 12, 19, 15, 22, 30, $totalApplyJobs])
        ->extraAttributes($cleanCardStyle),

      Stat::make('الحجوزات النشطة', $activeSubscriptions)
        ->description("قيد الانتظار: {$pendingSubscriptions}")
        ->descriptionIcon('heroicon-m-credit-card')
        ->color($pendingSubscriptions > 0 ? 'warning' : 'success')
        ->url(route('filament.admin.resources.subscriptions.index'))
        ->chart([3, 6, 9, 12, 10, 18, $activeSubscriptions])
        ->extraAttributes($cleanCardStyle),

      Stat::make('طلبات الترقية المعلقة', $pendingUpgradeRequests)
        ->description('بانتظار مراجعة الإدارة')
        ->descriptionIcon('heroicon-m-clock')
        ->color($pendingUpgradeRequests > 0 ? 'warning' : 'success')
        ->url(route('filament.admin.resources.account-upgrade-requests.index'))
        ->chart([2, 4, 3, 5, 4, 6, $pendingUpgradeRequests])
        ->extraAttributes($cleanCardStyle),

      Stat::make('الترقيات النشطة', $activeUpgradesCount)
        ->description('الحسابات التي تم ترقيتها وتعمل حالياً')
        ->descriptionIcon('heroicon-m-shield-check')
        ->color('success')
        ->url(route('filament.admin.resources.account-upgradeds.index'))
        ->chart([5, 8, 10, 12, 15, 19, $activeUpgradesCount])
        ->extraAttributes($cleanCardStyle),
    ];
  }
}
