<?php

namespace App\Filament\Resources\KadrNeeds\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KadrNeedInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل احتياج الكادر الوظيفي')
          ->description('بيانات الطلب والمهن المطلوبة والعمال المرتبطين.')
          ->icon('heroicon-o-information-circle')
          ->schema([
            Grid::make(2)->schema([
              TextEntry::make('kadr.name')
                ->label('اسم الكادر')
                ->color('primary')
                ->weight('bold'),

              TextEntry::make('required_profession')
                ->label('المهنة أو الصنعة')
                ->badge()
                ->color('warning'),
            ]),

            Grid::make(4)->schema([
              TextEntry::make('required_workers_count')
                ->label('عدد العمال')
                ->icon('heroicon-m-users')
                ->extraAttributes(['style' => 'font-variant-numeric: lnum;']),

              TextEntry::make('needed_at')
                ->label('توقيت الاحتياج')
                ->icon('heroicon-m-clock')
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'today' => 'اليوم',
                  'this_week' => 'خلال أسبوع',
                  'this_month' => 'خلال شهر',
                  'not_specified_yet' => 'غير محدد بعد',
                  default => $state,
                }),

              TextEntry::make('employment_type')
                ->label('نوع الدوام')
                ->icon('heroicon-m-briefcase')
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'full_time' => 'دوام كامل',
                  'part_time' => 'دوام جزئي',
                  'daily_wage' => 'مياومة',
                  default => $state,
                }),

              TextEntry::make('offered_salary')
                ->label('الأجر المعروض')
                ->icon('heroicon-m-banknotes')
                ->color('success')
                ->placeholder('لم يحدد')
                ->state(function ($record) {
                  return $record->offered_salary
                    ? number_format($record->offered_salary) . ' ' . ($record->currency === 'USD' ? 'دولار' : 'ليرة')
                    : null;
                })
                ->extraAttributes(['style' => 'font-variant-numeric: lnum;']),
            ]),



            RepeatableEntry::make('workers')
              ->label('العمال المرتبطين وحالة كل عامل')
              ->schema([
                Grid::make(2)->schema([
                  TextEntry::make('full_name')
                    ->label('اسم العامل'),


                ]),
              ])
              ->grid(2)
              ->placeholder('لا يوجد عمال مرتبطين حالياً')
              ->columnSpanFull(),

            TextEntry::make('additional_details')
              ->label('تفاصيل إضافية عن الاحتياج')
              ->placeholder('لا توجد تفاصيل إضافية.')
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
