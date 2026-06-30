<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Worker;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
  protected ?string $pollingInterval = '15s';

  protected function getStats(): array
  {
    $companiesCount = Company::count();
    $workersCount = Worker::count();

    $activeSubscriptions = Subscription::where('status', 'active')->count();
    $pendingSubscriptions = Subscription::where('status', 'pending')->count();

    return [
      Stat::make('إجمالي الشركات', $companiesCount)
        ->description('الشركات المسجلة بالنظام')
        ->descriptionIcon('heroicon-m-building-office-2')
        ->color('info')
        ->url(route('filament.admin.resources.companies.index'))
        ->extraAttributes([
          'style' => 'font-variant-numeric: lnum; font-family: cairo;',
        ]),

      Stat::make('إجمالي العمال', $workersCount)
        ->description('الكوادر والعمال المسجلين')
        ->descriptionIcon('heroicon-m-users')
        ->color('purple')
        ->url(route('filament.admin.resources.workers.index'))
        ->extraAttributes([
          'style' => 'font-variant-numeric: lnum; font-family: cairo;',
        ]),

      Stat::make('الحجوزات النشطة', $activeSubscriptions)
        ->description("يوجد {$pendingSubscriptions} في قيد الانتظار")
        ->descriptionIcon('heroicon-m-credit-card')
        ->color($pendingSubscriptions > 0 ? 'warning' : 'success')
        ->url(route('filament.admin.resources.subscriptions.index'))
        ->extraAttributes([
          'style' => 'font-variant-numeric: lnum; font-family: cairo;',
        ]),
    ];
  }
}