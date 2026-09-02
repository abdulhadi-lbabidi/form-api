<?php

namespace App\Filament\Resources\KadrJobHostings\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KadrJobHostingInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('تفاصيل شاغر الكادر')
          ->description('معلومات الوظيفة، الشركة المعلنة، الأجور، وتفاصيل الدوام.')
          ->icon('heroicon-o-briefcase')
          ->schema([
            Grid::make(3)->schema([
              TextEntry::make('title')
                ->label('عنوان الوظيفة')
                ->weight('bold')
                ->color('primary'),

              TextEntry::make('kadr.name')
                ->label('الكادر المعلن')
                ->placeholder('غير مسجل')
                ->icon('heroicon-m-user'),

              TextEntry::make('categories.name')
                ->label('التصنيفات')
                ->badge()
                ->color('info')
                ->separator(', '),

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

            Grid::make(2)->schema([
              TextEntry::make('salary_min')
                ->label('الحد الأدنى للراتب')
                ->placeholder('غير محدد')
                ->formatStateUsing(fn($state) => $state ? number_format((float) $state, 2) : null)
                ->extraAttributes(['dir' => 'ltr', 'style' => 'text-align: right;']),

              TextEntry::make('salary_max')
                ->label('الحد الأعلى للراتب')
                ->placeholder('غير محدد')
                ->formatStateUsing(fn($state) => $state ? number_format((float) $state, 2) : null)
                ->extraAttributes(['dir' => 'ltr', 'style' => 'text-align: right;']),

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

        Section::make('العمال المتقدمون على الوظيفة')
          ->description('قائمة الأشخاص الذين قاموا بالتقديم على هذا الشاغر.')
          ->icon('heroicon-o-users')
          ->schema([
            RepeatableEntry::make('applyJobs')
              ->label('')
              ->schema([
                TextEntry::make('worker.full_name')
                  ->label('اسم العامل')
                  ->icon('heroicon-m-user'),

                TextEntry::make('worker.phone_whatsapp')
                  ->label('رقم الواتساب')
                  ->icon('heroicon-m-phone'),

                TextEntry::make('status')
                  ->label('حالة الطلب')
                  ->badge()
                  ->formatStateUsing(fn(string $state): string => match ($state) {
                    'pending'  => 'قيد الانتظار',
                    'accepted' => 'مقبول',
                    'rejected' => 'مرفوض',
                    default    => $state,
                  })
                  ->color(fn(string $state): string => match ($state) {
                    'pending'  => 'warning',
                    'accepted' => 'success',
                    'rejected' => 'danger',
                    default    => 'gray',
                  }),

                TextEntry::make('notes')
                  ->label('ملاحظات المتقدم')
                  ->placeholder('لا توجد ملاحظات'),

                TextEntry::make('created_at')
                  ->label('تاريخ التقديم')
                  ->dateTime('Y-m-d H:i'),
              ])
              ->columns(3)
              ->columnSpanFull(),
          ])->columnSpanFull(),
      ]);
  }
}
