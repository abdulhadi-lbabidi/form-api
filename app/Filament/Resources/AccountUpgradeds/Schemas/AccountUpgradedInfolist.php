<?php

namespace App\Filament\Resources\AccountUpgradeds\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AccountUpgradedInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل الترقية')
          ->description('عرض معلومات ترقية الحساب بالكامل.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('accountUpgradeRequest.id')
                ->label('رقم طلب الترقية')
                ->formatStateUsing(fn($state) => "طلب #" . $state)
                ->badge()
                ->color('info')
                ->icon('heroicon-m-document-text'),

              TextEntry::make('status')
                ->label('الحالة')
                ->formatStateUsing(fn($state) => match ($state) {
                  'active' => 'نشط',
                  'expired' => 'منتهي',
                  'cancelled' => 'ملغي',
                  default => $state,
                })
                ->badge()
                ->color(fn($state) => match ($state) {
                  'active' => 'success',
                  'expired' => 'danger',
                  'cancelled' => 'warning',
                  default => 'gray',
                }),

              TextEntry::make('start_date')
                ->label('تاريخ البداية')
                ->date('Y-m-d')
                ->icon('heroicon-m-calendar'),

              TextEntry::make('end_date')
                ->label('تاريخ النهاية')
                ->date('Y-m-d')
                ->icon('heroicon-m-calendar'),

              TextEntry::make('comosion')
                ->label('العمولة')
                ->money('USD')
                ->icon('heroicon-m-currency-dollar'),

              TextEntry::make('created_at')
                ->label('تاريخ الإنشاء')
                ->dateTime('Y-m-d H:i')
                ->icon('heroicon-m-clock'),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
