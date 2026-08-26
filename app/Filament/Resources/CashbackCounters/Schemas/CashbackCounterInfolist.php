<?php

namespace App\Filament\Resources\CashbackCounters\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CashbackCounterInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل عداد الصفقة')
          ->description('عرض كافة تفاصيل العداد المرتبط بالصفقة والجهة.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('cashbackDeal.title')
                ->label('صفقة الكاش باك')
                ->weight('bold')
                ->color('primary')
                ->icon('heroicon-m-tag')
                ->columnSpanFull(),

              TextEntry::make('counterable_type')
                ->label('نوع الجهة المرتبطة')
                ->formatStateUsing(function ($state) {
                  return match ($state) {
                    'App\Models\Company' => 'شركة',
                    'App\Models\Worker'  => 'عامل',
                    'App\Models\Kadr'    => 'كادر',
                    default              => $state,
                  };
                })
                ->badge()
                ->color('warning')
                ->icon('heroicon-m-building-office'),

              TextEntry::make('counterable')
                ->label('اسم الجهة المرتبطة')
                ->getStateUsing(function ($record) {
                  if (!$record->counterable) return 'غير متوفر';

                  return match (get_class($record->counterable)) {
                    'App\Models\Company' => $record->counterable->company_name ?? 'شركة #' . $record->counterable->id,
                    'App\Models\Worker'  => $record->counterable->full_name ?? 'عامل #' . $record->counterable->id,
                    'App\Models\Kadr'    => $record->counterable->name ?? 'كادر #' . $record->counterable->id,
                    default              => 'معرف #' . $record->counterable->id,
                  };
                })
                ->badge()
                ->color('success')
                ->icon('heroicon-m-user'),

              TextEntry::make('created_at')
                ->label('تاريخ ووقت الإضافة')
                ->dateTime('Y-m-d H:i A')
                ->icon('heroicon-m-clock')
                ->columnSpanFull()
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
