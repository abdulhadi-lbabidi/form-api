<?php

namespace App\Filament\Resources\CompanyJobHostings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyJobHostingInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل شاغر الشركة')
          ->description('معلومات الوظيفة، الشركة المعلنة، الأجور، وتفاصيل الدوام.')
          ->icon('heroicon-o-briefcase')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('title')
                ->label('عنوان الوظيفة')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('company.company_name')
                ->label('الشركة المعلنة')
                ->placeholder('غير مسجل')
                ->icon('heroicon-m-building-office-2'),

              TextEntry::make('status')
                ->label('حالة الشاغر')
                ->badge()
                ->formatStateUsing(fn(string $state): string => match ($state) {
                  'pending'  => 'قيد المراجعة',
                  'approved' => 'نشط ومعتمد',
                  'rejected' => 'مرفوض',
                  'closed'   => 'مغلق',
                  default    => $state,
                })
                ->color(fn(string $state): string => match ($state) {
                  'pending'  => 'warning',
                  'approved' => 'success',
                  'rejected' => 'danger',
                  'closed'   => 'gray',
                  default    => 'gray',
                }),

              TextEntry::make('job_type')
                ->label('نوع الدوام')
                ->badge()
                ->color('info'),

              TextEntry::make('workers_count')
                ->label('عدد العمال المطلوبين')
                ->formatStateUsing(fn($state) => "{$state} عمال")
                ->color('danger')
                ->weight('bold'),

              TextEntry::make('shift_period')
                ->label('فترة الدوام')
                ->badge(),

              TextEntry::make('experience_level')
                ->label('مستوى الخبرة'),

              TextEntry::make('city')
                ->label('المدينة')
                ->icon('heroicon-m-map-pin')
                ->color('primary'),

              TextEntry::make('district')
                ->label('المنطقة / الحي')
                ->placeholder('غير محدد'),
            ]),

            Grid::make(2)->schema([
              TextEntry::make('time_from')
                ->label('من الساعة')
                ->placeholder('غير محدد'),

              TextEntry::make('time_to')
                ->label('إلى الساعة')
                ->placeholder('غير محدد'),
            ]),

            Grid::make(3)->schema([
              TextEntry::make('salary_min')
                ->label('الحد الأدنى للراتب')
                ->placeholder('غير محدد')
                ->numeric(),

              TextEntry::make('salary_max')
                ->label('الحد الأعلى للراتب')
                ->placeholder('غير محدد')
                ->numeric(),

              TextEntry::make('salary_info')
                ->label('الراتب والعملة والدورية')
                ->state(function ($record) {
                  if (!$record->salary_min && !$record->salary_max) return 'غير محدد';
                  return "من {$record->salary_min} إلى {$record->salary_max} {$record->currency} ({$record->salary_interval})";
                })
                ->color('success')
                ->weight('bold'),
            ]),

            TextEntry::make('notes')
              ->label('ملاحظات تفصيلية')
              ->placeholder('لا توجد ملاحظات إضافية.')
              ->columnSpanFull(),

            TextEntry::make('created_at')
              ->label('تاريخ الإنشاء')
              ->dateTime('Y-m-d H:i A')
              ->icon('heroicon-m-calendar'),
          ])->columnSpanFull(),
      ]);
  }
}
