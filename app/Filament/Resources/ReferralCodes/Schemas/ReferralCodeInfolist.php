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
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('code')
                ->label('كود الإحالة')
                ->weight('bold')
                ->copyable(), // يتيح للمشرف نسخ الكود بضغطة زر واحدة!

              TextEntry::make('referralable_type')
                ->label('نوع الكيان')
                ->formatStateUsing(fn($state) => $state === 'App\Models\Company' ? 'شركة' : 'عامل'),

              TextEntry::make('referralable')
                ->label('اسم المستفيد')
                ->formatStateUsing(fn($record) => $record->referralable?->company_name ?? ($record->referralable?->first_name . ' ' . $record->referralable?->last_name)),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('usage_limit')
                ->label('الحد الأقصى للاستخدام')
                ->placeholder('غير محدود'),

              TextEntry::make('times_used')
                ->label('مرات الاستخدام الفعلية'),

              TextEntry::make('expires_at')
                ->label('تاريخ الانتهاء')
                ->dateTime('Y-m-d H:i A')
                ->placeholder('لا ينتهي'),
            ]),

            IconEntry::make('is_active')
              ->label('حالة الكود')
              ->boolean(),
          ])->columnSpanFull(),
      ]);
  }
}
