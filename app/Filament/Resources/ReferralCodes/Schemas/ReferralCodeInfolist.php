<?php

namespace App\Filament\Resources\ReferralCodes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReferralCodeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل كود الإحالة')
          ->description('معلومات تتبع كود الإحالة ونوع المستفيد منه ومعدلات استخدامه الحالية.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('code')
                ->label('كود الإحالة')
                ->weight('bold')
                ->fontFamily('mono')
                ->color('primary')
                ->copyable()
                ->copyMessage('تم نسخ كود الإحالة بنجاح')
                ->icon('heroicon-m-clipboard-document-check'),

              TextEntry::make('referralable_type')
                ->label('نوع الكيان المستفيد')
                ->formatStateUsing(fn($state) => $state === 'App\Models\Company' ? 'شركة' : 'عامل')
                ->color(fn($state) => $state === 'App\Models\Company' ? 'info' : 'purple'),

              TextEntry::make('owner_name')
                ->label('اسم صاحب الكود')
                ->icon('heroicon-m-user')
                ->state(function ($record) {
                  return $record->referralable?->company_name
                    ?? ($record->referralable ? "{$record->referralable->first_name} {$record->referralable->last_name}" : '-');
                }),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('times_used')
                ->label('الاستخدام الحالي / الحد الأقصى')
                ->icon('heroicon-m-arrow-trending-up')
                ->state(function ($record) {
                  $limit = $record->usage_limit ?? '∞';
                  return "{$record->times_used} / {$limit}";
                })
                ->color(fn($record) => $record->usage_limit && $record->times_used >= $record->usage_limit ? 'danger' : 'gray')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo; font-weight: bold;']),

              TextEntry::make('expires_at')
                ->label('تاريخ انتهاء الصلاحية')
                ->icon('heroicon-m-calendar')
                ->dateTime('Y-m-d H:i A')
                ->placeholder('مفتوح الصلاحية (لا ينتهي)')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum; font-family: cairo;']),

              IconEntry::make('is_active')
                ->label('حالة الكود بالنظام')
                ->boolean(),
            ]),
          ])->columnSpanFull(),
      ]);
  }
}
